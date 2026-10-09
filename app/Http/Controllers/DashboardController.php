<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Presensi;
use App\Models\Pengajuan;
use App\Exports\PresensiExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $pendingPengajuan = 0;
        $pengajuans = collect();

        // Sorting
        $sortBy = $request->input('sort_by', 'date');
        $sort = $request->input('sort', 'desc');

        // Prevent invalid sorting values
        if (!in_array($sortBy, ['name', 'date'])) {
            $sortBy = 'date';
        }

        if (!in_array($sort, ['asc', 'desc'])) {
            $sort = 'desc';
        }

        // Admin
        if ($user->role === 'admin') {

            $summary = Presensi::selectRaw('status, COUNT(*) as total')
                ->groupBy('status')
                ->pluck('total', 'status');

            $presensis = Presensi::with('user');

            // Filter status
            if ($request->filled('status')) {
                $presensis->where('status', $request->status);
            }

            // Filter date
            if ($request->filled('date')) {
                $presensis->whereDate('date', $request->date);
            }

            // Search name
            if ($request->filled('search')) {
                $presensis->whereHas('user', function ($query) use ($request) {
                    $query->where(
                        'name',
                        'like',
                        '%' . $request->search . '%'
                    );
                });
            }

            // Sorting
            if ($sortBy === 'name') {

                $presensis
                    ->join(
                        'users',
                        'presensis.user_id',
                        '=',
                        'users.id'
                    )
                    ->select('presensis.*')
                    ->orderBy('users.name', $sort);

            } else {

                $presensis
                    ->orderBy('presensis.date', $sort)
                    ->orderBy('presensis.id', $sort);
            }

            // Pagination
            $presensis = $presensis
                ->paginate(10)
                ->withQueryString();

            // Notification
            $pendingPengajuan = Pengajuan::where('status', 'pending')
                ->count();

            $pengajuans = Pengajuan::with('user')
                ->where('status', 'pending')
                ->latest('created_at')
                ->get();

        // User
        } else {

            $summary = Presensi::where('user_id', $user->id)
                ->selectRaw('status, COUNT(*) as total')
                ->groupBy('status')
                ->pluck('total', 'status');

            $presensis = Presensi::where('user_id', $user->id);

            // Filter status
            if ($request->filled('status')) {
                $presensis->where('status', $request->status);
            }

            // Filter date
            if ($request->filled('date')) {
                $presensis->where('date', $request->date);
            }

            // User can only sort by date
            $presensis = $presensis
                ->orderBy('date', $sort)
                ->orderBy('id', $sort)
                ->paginate(10)
                ->withQueryString();
        }

        return view('dashboard', compact(
            'summary',
            'presensis',
            'pendingPengajuan',
            'pengajuans'
        ));
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(
            new PresensiExport($request),
            'laporan-presensi.xlsx'
        );
    }

    public function exportPdf(Request $request)
    {
        $query = Presensi::with('user');

        // Search nama
        if ($request->filled('search')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where(
                    'name',
                    'like',
                    '%' . $request->search . '%'
                );
            });
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter tanggal
        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        }

        $presensis = $query
            ->orderByDesc('date')
            ->get();

        $pdf = Pdf::loadView('pdf.presensi', [
            'presensis' => $presensis,
        ]);

        return $pdf
            ->setPaper('a4', 'landscape')
            ->download('laporan-presensi.pdf');
    }
}