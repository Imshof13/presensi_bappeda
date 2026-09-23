<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengajuanController extends Controller
{
    //
    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => [
                'required',
                'date',
            ],

            'mengajukan' => [
                'required',
                'in:sakit,izin',
            ],

            'alasan' => [
                'nullable',
                'string',
            ],

            'bukti' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png',
                'max:2048',
            ],
        ]);

        $bukti = null;

        if ($request->hasFile('bukti')) {
            $bukti = $request->file('bukti')
                ->store('bukti-pengajuan', 'public');
        }

        Pengajuan::create([
            'user_id' => Auth::id(),
            'tanggal' => $request->tanggal,
            'mengajukan' => $request->mengajukan,
            'alasan' => $request->alasan,
            'bukti' => $bukti,
            'status' => 'pending',
            'dicek_oleh' => null,
            'dicek_saat' => null,
        ]);

        return back()->with(
            'success',
            'Pengajuan berhasil dikirim kepada admin.'
        );
    }
}