<?php

namespace App\Http\Controllers\Penyaluran;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PenyaluranController extends Controller
{
    public function index()
    {
        return view('admin.penyaluran.penyaluran-index');
    }

    public function create()
    {
        return view('admin.penyaluran.penyaluran-create');
    }

    public function store(Request $request)
    {
        // TODO: Validasi dan simpan data penyaluran zakat.
    }

    public function show(string $id)
    {
        return view('admin.penyaluran.penyaluran-show', compact('id'));
    }

    public function edit(string $id)
    {
        return view('admin.penyaluran.penyaluran-edit', compact('id'));
    }

    public function update(Request $request, string $id)
    {
        // TODO: Validasi dan perbarui data penyaluran zakat.
    }

    public function destroy(string $id)
    {
        // TODO: Hapus data penyaluran zakat.
    }
}
