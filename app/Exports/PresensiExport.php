<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use App\Models\Presensi;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class PresensiExport implements FromCollection, WithHeadings, WithEvents
{
    protected Request $request;
    protected ?int $userId;

    public function __construct(Request $request, ?int $userId = null)
    {
        $this->request = $request;
        $this->userId = $userId;
    }

    public function collection(): Collection
    {
        $query = Presensi::with('user');

        // Jika userId diberikan, batasi data ke user tersebut.
        if ($this->userId !== null) {
            $query->where('user_id', $this->userId);
        }

        if ($this->request->filled('search') && $this->userId === null) {
            $query->whereHas('user', function ($q) {
                $q->where('name', 'like', '%' . $this->request->search . '%');
            });
        }

        if ($this->request->filled('status')) {
            $query->where('status', $this->request->status);
        }

        if ($this->request->filled('month')) {
            $query->whereMonth('date', $this->request->month);
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

        $sort = $this->request->input('sort', 'date_desc');

        if ($this->userId === null && in_array($sort, ['name_asc', 'name_desc'])) {
            $direction = $sort === 'name_asc' ? 'asc' : 'desc';

            $query->join('users', 'presensis.user_id', '=', 'users.id')
                ->select('presensis.*')
                ->orderBy('users.name', $direction);
        } else {
            $direction = $sort === 'date_asc' ? 'asc' : 'desc';

            $query->orderBy('date', $direction)
                ->orderBy('id', $direction);
        }

        return $query->get()->map(function ($presensi) {
            $keterangan = '-';

            if ($presensi->check_in && $presensi->check_out) {
                $totalMenit = Carbon::parse($presensi->check_in)
                    ->diffInMinutes(Carbon::parse($presensi->check_out));

                $jam = intdiv($totalMenit, 60);
                $menit = $totalMenit % 60;

                $keterangan = "{$jam} jam {$menit} menit";
            } elseif ($presensi->check_in && !$presensi->check_out) {
                $keterangan = 'Belum selesai';
            }

            return [
                $presensi->user->name,
                Carbon::parse($presensi->date)->format('d-m-Y'),
                $presensi->check_in,
                $presensi->check_out,
                ucfirst($presensi->status),
                $keterangan,
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
                $event->sheet->insertNewRowBefore(1, 4);
                $event->sheet->setCellValue('A1', 'LAPORAN PRESENSI PEGAWAI');

                $event->sheet->setCellValue(
                    'A2',
                    $this->userId !== null ? 'Nama Pegawai' : 'Filter Nama'
                );

                $event->sheet->setCellValue(
                    'B2',
                    $this->userId !== null
                        ? auth()->user()->name
                        : ($this->request->input('search') ?: 'Semua')
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
