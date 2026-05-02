<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        return view('admin.laporan.laporan-index');
    }

    public function create()
    {
        return view('admin.laporan.laporan-create');
    }

    public function store(Request $request)
    {
        // TODO: Validasi dan simpan konfigurasi laporan.
    }

    public function show(string $id)
    {
        return view('admin.laporan.laporan-show', compact('id'));
    }

    public function edit(string $id)
    {
        return view('admin.laporan.laporan-edit', compact('id'));
    }

    public function update(Request $request, string $id)
    {
        // TODO: Validasi dan perbarui konfigurasi laporan.
    }

    public function destroy(string $id)
    {
        // TODO: Hapus konfigurasi laporan.
    }
}
