<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Pengajuan;

class Presensi extends Model
{
    protected $fillable = [
        'user_id',
        'date',
        'check_in',
        'check_out',
        'status',
        'note',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'check_in' => 'datetime:H:i',
            'check_out' => 'datetime:H:i',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function PengajuanDiterima()
    {
        return Pengajuan::where('user_id', $this->user_id)
            ->whereDate('tanggal', $this->date)
            ->where('status', 'diterima')
            ->first();
    }
}