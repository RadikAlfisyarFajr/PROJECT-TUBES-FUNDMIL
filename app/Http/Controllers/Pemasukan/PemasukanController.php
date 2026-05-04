<?php

namespace App\Http\Controllers\Pemasukan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PemasukanController extends Controller
{
    public function index()
    {
        return view('admin.pemasukan.pemasukan-index');
    }

    public function create()
    {
        return view('admin.pemasukan.pemasukan-create');
    }

    public function store(Request $request)
    {
        // TODO: Validasi dan simpan data pemasukan zakat.
    }

    public function show(string $id)
    {
        return view('admin.pemasukan.pemasukan-show', compact('id'));
    }

    public function edit(string $id)
    {
        return view('admin.pemasukan.pemasukan-edit', compact('id'));
    }

    public function update(Request $request, string $id)
    {
        // TODO: Validasi dan perbarui data pemasukan zakat.
    }

    public function destroy(string $id)
    {
        // TODO: Hapus data pemasukan zakat.
    }
}
