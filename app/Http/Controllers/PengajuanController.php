<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengajuanController extends Controller
{
    //
    public function create()
    {
        return view('pengajuan.create');
    }

    public function store(Request $request)
    {
        // We'll implement this later
    }

    public function index()
    {
        // We'll implement this later
    }

    public function approve($id)
    {
        // We'll implement this later
    }

    public function reject($id)
    {
        // We'll implement this later
    }
}