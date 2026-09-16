<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pengajuan extends Model
{
    use HasFactory;

    protected $table = 'pengajuan';

    protected $fillable = [
        'user_id',
        'tanggal',
        'mengajukan',
        'alasan',
        'bukti',
        'status',
        'dicek_oleh',
        'dicek_saat',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
            'dicek_saat' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function pemeriksa(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dicek_oleh');
    }
}