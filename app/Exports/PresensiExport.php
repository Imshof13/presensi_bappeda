<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Http\Request;
use App\Models\Presensi;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class PresensiExport implements FromCollection, WithHeadings, WithEvents
{
    protected Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection(): Collection
    {
        $query = Presensi::with('user');

        // Search employee name
        if ($this->request->filled('search')) {
            $query->whereHas('user', function ($q) {
                $q->where(
                    'name',
                    'like',
                    '%' . $this->request->search . '%'
                );
            });
        }

        // Filter status
        if ($this->request->filled('status')) {
            $query->where('status', $this->request->status);
        }
        
        // Filter tanggal
        if ($this->request->filled('month')) {
            $query->whereMonth('date', $this->request->month    );
        }

        if ($this->request->filled('year')) {
            $query->whereYear('date', $this->request->year);
        }

        if ($this->request->filled('date_from')) {
            $query->where('date', '>=', $this->request->date_from);
        }

        if ($this->request->filled('date_to')) {
            $query->where('date', '<=', $this->request->date_to);
        }

        // Sorting
        $sort = $this->request->input('sort', 'date_desc');

        if ($sort === 'name_asc' || $sort === 'name_desc') {

            $direction = $sort === 'name_asc' ? 'asc' : 'desc';

            $query
                ->join('users', 'presensis.user_id', '=', 'users.id')
                ->select('presensis.*')
                ->orderBy('users.name', $direction);

        } elseif ($sort === 'date_asc') {

            $query
                ->orderBy('presensis.date', 'asc')
                ->orderBy('presensis.id', 'asc');

        } else {

            $query
                ->orderBy('presensis.date', 'desc')
                ->orderBy('presensis.id', 'desc');
        }

        return $query
            ->get()
            ->map(function ($presensi) {
                return [
                    $presensi->user->name,
                    $presensi->date->format('d-m-Y'),
                    $presensi->check_in ?? '-',
                    $presensi->check_out ?? '-',
                    ucfirst($presensi->status ?? '-'),
                    $presensi->note ?? '-',
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Nama',
            'Tanggal',
            'Masuk',
            'Pulang',
            'Status',
            'Keterangan',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Insert space above the column headings and data.
                $event->sheet->insertNewRowBefore(1, 4);
                $event->sheet->setCellValue('A1', 'LAPORAN PRESENSI PEGAWAI');
                $event->sheet->setCellValue('A2', 'Filter Nama');
                $event->sheet->setCellValue(
                    'B2',
                    $this->request->input('search') ?: 'Semua'
                );
                $event->sheet->setCellValue('A3', 'Filter Status');
                $event->sheet->setCellValue(
                    'B3',
                    $this->request->filled('status')
                        ? ucfirst($this->request->input('status'))
                        : 'Semua'
                );
                $event->sheet->setCellValue('A4', 'Rentang Tanggal');
                $event->sheet->setCellValue(
                    'B4',
                    ($this->request->input('date_from') ?: 'Awal') .
                    ' sampai ' .
                    ($this->request->input('date_to') ?: 'Akhir')
                );
            },
        ];
    }
}
