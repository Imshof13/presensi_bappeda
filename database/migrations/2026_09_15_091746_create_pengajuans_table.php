<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pengajuan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');
            $table->date('tanggal');
            $table->enum('mengajukan', [
                'sakit',
                'izin'
            ]);
            $table->text('alasan')->nullable();
            $table->string('bukti')->nullable();
            $table->enum('status', [
                'pending',
                'diterima',
                'ditolak'
            ])->default('pending');
            $table->foreignId('dicek_oleh')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->timestamp('dicek_saat')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuans');
    }
};
