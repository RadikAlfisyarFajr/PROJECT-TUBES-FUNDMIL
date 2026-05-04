<?php

namespace App\Http\Controllers\SuperAdmin\HargaBeras;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HargaBerasController extends Controller
{
    public function index()
    {
        return view('superadmin.harga-beras.harga-beras-index');
    }

    public function create()
    {
        return view('superadmin.harga-beras.harga-beras-create');
    }

    public function store(Request $request)
    {
        // TODO: Validasi dan simpan harga beras.
    }

    public function show(string $id)
    {
        return view('superadmin.harga-beras.harga-beras-show', compact('id'));
    }

    public function edit(string $id)
    {
        return view('superadmin.harga-beras.harga-beras-edit', compact('id'));
    }

    public function update(Request $request, string $id)
    {
        // TODO: Validasi dan perbarui harga beras.
    }

    public function destroy(string $id)
    {
        // TODO: Hapus data harga beras.
    }
}
