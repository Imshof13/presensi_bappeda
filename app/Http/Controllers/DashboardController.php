<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Presensi;
class DashboardController extends Controller
{
    //
    public function index(Request $request)
    {
        $user = Auth::user();

        // Admin
        if ($user->role === 'admin') {
            $summary = Presensi::selectRaw('status, COUNT(*) as total')
                ->groupBy('status')
                ->pluck('total', 'status');

            $presensis = Presensi::with('user');

                if ($request->filled('status')) {
                    $presensis->where('status', $request->status);
                }

                if ($request->filled('date')) {
                    $presensis->whereDate('date', $request->date);
                }

                if ($request->filled('search')) {
                    $presensis->whereHas('user', function ($query) use ($request) {
                        $query->where('name', 'like', '%' . $request->search . '%');
                    });
                }

                $presensis = $presensis
                    ->latest('date')
                    ->get();

        // User 
        } else {
            $summary = Presensi::where('user_id', $user->id)
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

            $presensis = Presensi::where('user_id', $user->id);
                if ($request->filled('status')) {
                    $presensis->where('status', $request->status);
                }

                if ($request->filled('date')) {
                    $presensis->where('date', $request->date);
                }

                $presensis = $presensis
                    ->latest('date')
                    ->get();
            }

            return view('dashboard', compact(
                'summary',
                'presensis'
            ));
    }
}