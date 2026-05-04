<?php

namespace App\Http\Controllers\KategoriDana;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KategoriDanaController extends Controller
{
    public function index()
    {
        return view('admin.kategori-dana.kategori-dana-index');
    }

    public function create()
    {
        return view('admin.kategori-dana.kategori-dana-create');
    }

    public function store(Request $request)
    {
        // TODO: Validasi dan simpan data kategori dana.
    }

    public function show(string $id)
    {
        return view('admin.kategori-dana.kategori-dana-show', compact('id'));
    }

    public function edit(string $id)
    {
        return view('admin.kategori-dana.kategori-dana-edit', compact('id'));
    }

    public function update(Request $request, string $id)
    {
        // TODO: Validasi dan perbarui data kategori dana.
    }

    public function destroy(string $id)
    {
        // TODO: Hapus data kategori dana.
    }
}
