<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Presensi;
class DashboardController extends Controller
{
    //
    public function index()
    {
        $user = Auth::user();
        // Admin
        if ($user->role === 'admin') {
            $summary = Presensi::selectRaw('status, COUNT(*) as total')
                ->groupBy('status')
                ->pluck('total', 'status');

            $presensis = Presensi::with('user')
                ->latest('date')
                ->get();
        // User 
        } else {
            $summary = Presensi::where('user_id', $user->id)
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $presensis = Presensi::where('user_id', $user->id)
            ->latest('date')
            ->get();
        }

        return view('dashboard', compact(
            'summary',
            'presensis'
        ));
    }
}