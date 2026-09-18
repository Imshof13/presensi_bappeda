<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Presensi;

class PresensiController extends Controller
{
    //
    public function index()
    {
        $user = Auth::user();

        $presensi = Presensi::where('user_id', $user->id)
            ->where('date', today())
            ->first();

        return view('presensi', compact('presensi'));
    }

    public function checkIn()
    {
        $user = Auth::user();

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

            $minutesEarly = $now->diffInMinutes($deadline);

            $note = "Keluar {$minutesEarly} menit lebih cepat";

        } elseif ($now->gt($deadline)) {

            $minutesLate = $deadline->diffInMinutes($now);

            $note = "Keluar lebih lama {$minutesLate} menit";
        }

        $presensi->update([
            'check_out' => $now,
            'note' => $note,
        ]);

        return back()->with('success', 'Presensi pulang berhasil.');
    }
}
