<?php

namespace Database\Seeders;

use App\Models\Pengajuan;
use App\Models\User;
use Illuminate\Database\Seeder;

class PengajuanSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('role', 'user')->orderBy('id')->get();
        $admin = User::where('username', 'admin')->first();

        if ($users->isEmpty()) {
            return;
        }

        $types = ['izin', 'sakit'];
        $statuses = ['pending', 'diterima', 'ditolak'];

        // Buat 50 data pengajuan dengan kombinasi jenis dan status.
        for ($i = 0; $i < 50; $i++) {
            $user = $users[$i % $users->count()];
            $status = $statuses[$i % count($statuses)];
            $type = $types[$i % count($types)];

            $reviewed = $status !== 'pending';

            Pengajuan::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'tanggal' => now()->subDays($i + 60)->toDateString(),
                ],
                [
                    'mengajukan' => $type,
                    'alasan' => $type === 'sakit'
                        ? 'Sedang kurang sehat dan perlu beristirahat.'
                        : 'Ada keperluan pribadi/keluarga.',
                    'bukti' => null,
                    'status' => $status,
                    'dicek_oleh' => $reviewed ? $admin?->id : null,
                    'dicek_saat' => $reviewed ? now()->subDays($i)->setTime(8, 0) : null,
                ]
            );
        }
    }
}
