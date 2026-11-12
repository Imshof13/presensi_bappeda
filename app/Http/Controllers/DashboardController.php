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
        $yearsQuery = Presensi::query();
            if ($user->role !== 'admin') {
                $yearsQuery->where('user_id', $user->id);
            }

            $years = $yearsQuery
                ->selectRaw('YEAR(date) as year')
                ->distinct()
                ->orderByDesc('year')
                ->pluck('year');

        // Validate date range
        $request->validate([
            'date_from' => 'nullable|date',
            'date_to' => 'nullable|date|after_or_equal:date_from',
        ]);

        // Sorting options
        $sort = $request->input('sort', 'date_desc');

        $allowedSorts = [
            'date_desc',
            'date_asc',
            'name_asc',
            'name_desc',
        ];

        if (!in_array($sort, $allowedSorts)) {
            $sort = 'date_desc';
        }

        // Validasi filter
        $request->validate([
            'date_from' => 'nullable|date',
            'date_to' => 'nullable|date|after_or_equal:date_from',
            'month' => 'nullable|integer|between:1,12',
            'year' => 'nullable|integer|digits:4',
        ]);

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

            // Filter bulan
            if ($request->filled('month')) {
                $presensis->whereMonth('date', $request->month);
            }

            // Filter tahun
            if ($request->filled('year')) {
                $presensis->whereYear('date', $request->year);
            }

            // Filter rentang tanggal
            if ($request->filled('date_from')) {
                $presensis->where('date', '>=', $request->date_from);
            }

            if ($request->filled('date_to')) {
                $presensis->where('date', '<=', $request->date_to);
            }

            // Search employee name
            if ($request->filled('search')) {
                $presensis->whereHas('user', function ($query) use ($request) {
                    $query->where(
                        'name',
                        'like',
                        '%' . $request->search . '%'
                    );
                });
            }

            // Sorting Admin
            if ($sort === 'name_asc' || $sort === 'name_desc') {

                $direction = $sort === 'name_asc' ? 'asc' : 'desc';

                $presensis
                    ->join('users', 'presensis.user_id', '=', 'users.id')
                    ->select('presensis.*')
                    ->orderBy('users.name', $direction);

            } elseif ($sort === 'date_asc') {

                $presensis
                    ->orderBy('presensis.date', 'asc')
                    ->orderBy('presensis.id', 'asc');

            } else {

                $presensis
                    ->orderBy('presensis.date', 'desc')
                    ->orderBy('presensis.id', 'desc');
            }

            $presensis = $presensis
                ->paginate(10)
                ->withQueryString();

            // Notification
            $pendingPengajuan = Pengajuan::where('status', 'pending')
                ->count();

            $pengajuans = Pengajuan::with('user')
                ->where('status', 'pending')
                ->latest('created_at')
                ->paginate(5, ['*'], 'notification_page')
                ->withQueryString();

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

            // Filter bulan
            if ($request->filled('month')) {
                $presensis->whereMonth('date', $request->month);
            }

            // Filter tahun
            if ($request->filled('year')) {
                $presensis->whereYear('date', $request->year);
            }

            // Filter rentang tanggal
            if ($request->filled('date_from')) {
                $presensis->where('date', '>=', $request->date_from);
            }

            if ($request->filled('date_to')) {
                $presensis->where('date', '<=', $request->date_to);
            }

            // User can only sort by date
            $direction = $sort === 'date_asc' ? 'asc' : 'desc';

            $presensis = $presensis
                ->orderBy('date', $direction)
                ->orderBy('id', $direction)
                ->paginate(10)
                ->withQueryString();
        }

        return view('dashboard', compact(
            'summary',
            'presensis',
            'pendingPengajuan',
            'pengajuans',
            'years'
        ));
    }

    public function exportExcel(Request $request)
    {
        $user = Auth::user();

        // Admin: seluruh data
        // User: hanya data miliknya
        $userId = $user->role === 'admin' ? null : $user->id;

        return Excel::download(
            new PresensiExport($request, $userId),
            'laporan-presensi.xlsx'
        );
    }

    public function exportPdf(Request $request)
    {
        $user = Auth::user();

        $query = Presensi::with('user');

        // Batasi data untuk user biasa
        if ($user->role !== 'admin') {
            $query->where('user_id', $user->id);
        }

        // Search nama hanya untuk admin
        if ($user->role === 'admin' && $request->filled('search')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter bulan
        if ($request->filled('month')) {
            $query->whereMonth('date', $request->month);
        }

        // Filter tahun
        if ($request->filled('year')) {
            $query->whereYear('date', $request->year);
        }

        // Filter rentang tanggal
        if ($request->filled('date_from')) {
            $query->where('date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('date', '<=', $request->date_to);
        }

        // Sorting
        $sort = $request->input('sort', 'date_desc');

        if ($user->role === 'admin' && in_array($sort, ['name_asc', 'name_desc'])) {
            $direction = $sort === 'name_asc' ? 'asc' : 'desc';

            $query
                ->join('users', 'presensis.user_id', '=', 'users.id')
                ->select('presensis.*')
                ->orderBy('users.name', $direction);

        } else {
            $direction = $sort === 'date_asc' ? 'asc' : 'desc';

            $query
                ->orderBy('presensis.date', $direction)
                ->orderBy('presensis.id', $direction);
        }

        $presensis = $query->get();

        $pdf = Pdf::loadView('pdf.presensi', [
            'presensis' => $presensis,
            'filters' => [
                'search' => $user->role === 'admin'
                    ? $request->input('search')
                    : null,
                'status' => $request->input('status'),
                'month' => $request->input('month'),
                'year' => $request->input('year'),
                'date_from' => $request->input('date_from'),
                'date_to' => $request->input('date_to'),
            ],
        ]);

        return $pdf
            ->setPaper('a4', 'landscape')
            ->download('laporan-presensi.pdf');
    }
}