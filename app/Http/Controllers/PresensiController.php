<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Presensi;
use App\Models\Pengajuan;
use App\Exports\PresensiExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class PresensiController extends Controller
{
    //
    private function hasActivePengajuan($userId, $tanggal)
    {
        return Pengajuan::where('user_id', $userId)
            ->whereDate('tanggal', $tanggal)
            ->whereIn('status', ['pending', 'diterima'])
            ->exists();
    }
    public function index()
    {
        $user = Auth::user();
            if ($user->role === 'admin') {
                $pengajuans = Pengajuan::with('user')
                    ->latest('created_at')
                    ->paginate(10, ['*'], 'pengajuan_page')
                    ->withQueryString();

                return view('presensi', compact('pengajuans'));
            }

        $presensiLama = Presensi::where('user_id', $user->id)
            ->where('date', '<', today())
            ->whereNull('check_out')
            ->get();

        foreach ($presensiLama as $data) {
            if (!$data->note) {
                $data->update([
                    'note' => 'Tidak melakukan check out',
                ]);
            }
        }

        $presensi = Presensi::where('user_id', $user->id)
            ->where('date', today())
            ->first();
        
        $riwayatPengajuan = Pengajuan::where('user_id', $user->id)
            ->latest('created_at')
            ->get();

        return view('presensi', compact('presensi', 'riwayatPengajuan'));   
    }

    public function checkIn()
    {
        $user = Auth::user();

        if ($this->hasActivePengajuan($user->id, today())) {
            return back()->with(
                'error',
                'Anda tidak dapat melakukan presensi karena sudah mengajukan izin atau sakit pada tanggal ini.'
            );
        }

        // Validasi user sudah check in
        $presensi = Presensi::where('user_id', $user->id)
            ->where('date', today())
            ->first();

        if ($presensi) {
            return back()->with('error', 'Anda sudah melakukan presensi masuk hari ini.');
        }

        $now = Carbon::now();

        // 07:30 AM
        $deadline = Carbon::today()->setTime(7, 30);

        if ($now->lte($deadline)) {
            $status = 'hadir';
        } else {
            $status = 'terlambat';
        }

        Presensi::create([
            'user_id' => $user->id,
            'date' => today(),
            'check_in' => $now,
            'check_out' => null,
            'status' => $status,
            'note' => null,
        ]);

        return back()->with('success', 'Presensi masuk berhasil.');
    }

    public function checkOut()
    {
        $user = Auth::user();

        if ($this->hasActivePengajuan($user->id, today())) {
            return back()->with(
                'error',
                'Anda tidak dapat melakukan presensi karena sudah mengajukan izin atau sakit pada tanggal ini.'
            );
        }

        $presensi = Presensi::where('user_id', $user->id)
            ->where('date', today())
            ->first();

        // User belum checkout
        if (!$presensi) {
            return back()->with(
                'error',
                'Anda belum melakukan presensi masuk.'
            );
        }

        // User sudah cehckout
        if ($presensi->check_out) {
            return back()->with(
                'error',
                'Anda sudah melakukan presensi pulang hari ini.'
            );
        }

        $now = Carbon::now();

        // 17:00
        $deadline = Carbon::today()->setTime(17, 0);

        $note = null;

        if ($now->lt($deadline)) {
            $minutesEarly = (int) round($now->diffInMinutes($deadline));

            if ($minutesEarly >= 60) {
                $hours = intdiv($minutesEarly, 60);
                $minutes = $minutesEarly % 60;

                if ($minutes > 0) {
                    $note = "Keluar {$hours} jam {$minutes} menit lebih cepat";
                } else {
                    $note = "Keluar {$hours} jam lebih cepat";
                }
            } else {
                $note = "Keluar {$minutesEarly} menit lebih cepat";
            }

        } elseif ($now->gt($deadline)) {
            $minutesLate = (int) round($deadline->diffInMinutes($now));

            if ($minutesLate >= 60) {
                $hours = intdiv($minutesLate, 60);
                $minutes = $minutesLate % 60;

                if ($minutes > 0) {
                    $note = "Keluar lebih lama {$hours} jam {$minutes} menit";
                } else {
                    $note = "Keluar lebih lama {$hours} jam";
                }
            } else {
                $note = "Keluar lebih lama {$minutesLate} menit";
            }
        }

        $presensi->update([
            'check_out' => $now,
            'note' => $note,
        ]);

        return back()->with('success', 'Presensi pulang berhasil.');
    }

    public function exportExcel(Request $request)
    {
        $user = Auth::user();

        if ($user->role !== 'user') {
            abort(403);
        }

        return Excel::download(
            new PresensiExport($request, $user->id),
            'laporan-presensi-' . $user->name . '.xlsx'
        );
    }

    public function exportPdf(Request $request)
    {
        $user = Auth::user();

        if ($user->role !== 'user') {
            abort(403);
        }

        $query = Presensi::where('user_id', $user->id)
            ->with('user');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('month')) {
            $query->whereMonth('date', $request->month);
        }

        if ($request->filled('year')) {
            $query->whereYear('date', $request->year);
        }

        if ($request->filled('date_from')) {
            $query->where('date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('date', '<=', $request->date_to);
        }

        $sort = $request->input('sort', 'date_desc');
        $direction = $sort === 'date_asc' ? 'asc' : 'desc';

        $presensis = $query
            ->orderBy('date', $direction)
            ->orderBy('id', $direction)
            ->get();

        $pdf = Pdf::loadView('pdf.presensi', [
            'presensis' => $presensis,
            'filters' => [
                'search' => null,
                'status' => $request->input('status'),
                'month' => $request->input('month'),
                'year' => $request->input('year'),
                'date_from' => $request->input('date_from'),
                'date_to' => $request->input('date_to'),
            ],
        ]);

        return $pdf
            ->setPaper('a4', 'landscape')
            ->download('laporan-presensi-' . $user->name . '.pdf');
    }
}
