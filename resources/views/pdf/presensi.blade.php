<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">

    <title>Laporan Presensi</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #333;
            padding: 7px;
        }

        th {
            background-color: #eeeeee;
            text-align: center;
        }

        td {
            vertical-align: middle;
        }

        .center {
            text-align: center;
        }

        .filter-information {
            margin-bottom: 18px;
            font-size: 10px;
        }

        .filter-information p {
            margin: 4px 0;
        }
    </style>
</head>

<body>

    <h2>Laporan Presensi Pegawai</h2>

    <div class="filter-information">
        <p>
            <strong>Filter Nama:</strong>
            {{ $filters['search'] ?: 'Semua' }}
        </p>

        <p>
            <strong>Filter Status:</strong>
            {{ $filters['status'] ? ucfirst($filters['status']) : 'Semua' }}
        </p>

        <p>
            <strong>Rentang Tanggal:</strong>
            {{ $filters['date_from'] ?: 'Awal' }}
            sampai
            {{ $filters['date_to'] ?: 'Akhir' }}
        </p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Tanggal</th>
                <th>Masuk</th>
                <th>Pulang</th>
                <th>Status</th>
                <th>Keterangan</th>
            </tr>
        </thead>

        <tbody>
            @forelse($presensis as $index => $presensi)
                <tr>
                    <td class="center">
                        {{ $index + 1 }}
                    </td>

                    <td>
                        {{ $presensi->user->name }}
                    </td>

                    <td class="center">
                        {{ $presensi->date->format('d-m-Y') }}
                    </td>

                    <td class="center">
                        {{ $presensi->check_in ?? '-' }}
                    </td>

                    <td class="center">
                        {{ $presensi->check_out ?? '-' }}
                    </td>

                    <td class="center">
                        {{ ucfirst($presensi->status ?? '-') }}
                    </td>

                    <td>
                    @php
                    $keterangan = '-';

                    if ($presensi->check_in && $presensi->check_out) {
                        $totalMenit = \Carbon\Carbon::parse($presensi->check_in)
                            ->diffInMinutes(\Carbon\Carbon::parse($presensi->check_out));

                        $jam = intdiv($totalMenit, 60);
                        $menit = $totalMenit % 60;

                        $keterangan = "{$jam} jam {$menit} menit";
                    } elseif ($presensi->check_in && !$presensi->check_out) {
                        $keterangan = 'Belum selesai';
                    }
                    @endphp

                    {{ $keterangan }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="center">
                        Tidak ada data presensi.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>