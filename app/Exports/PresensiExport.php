<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Http\Request;
use App\Models\Presensi;

class PresensiExport implements FromCollection, WithHeadings
{
    protected Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection(): Collection
    {
        $query = Presensi::with('user');

        if ($this->request->filled('search')) {
            $query->whereHas('user', function ($q) {
                $q->where('name', 'like', '%' . $this->request->search . '%');
            });
        }

        if ($this->request->filled('status')) {
            $query->where('status', $this->request->status);
        }

        if ($this->request->filled('date')) {
            $query->whereDate('date', $this->request->date);
        }

        return $query
            ->orderByDesc('date')
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
}
