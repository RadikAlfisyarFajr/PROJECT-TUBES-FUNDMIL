<?php

namespace App\Http\Controllers\ProgramPenyaluran;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProgramPenyaluranController extends Controller
{
    public function index()
    {
        return view('admin.program-penyaluran.program-penyaluran-index');
    }

    public function create()
    {
        return view('admin.program-penyaluran.program-penyaluran-create');
    }

    public function store(Request $request)
    {
        // TODO: Validasi dan simpan data program penyaluran.
    }

    public function show(string $id)
    {
        return view('admin.program-penyaluran.program-penyaluran-show', compact('id'));
    }

    public function edit(string $id)
    {
        return view('admin.program-penyaluran.program-penyaluran-edit', compact('id'));
    }

    public function update(Request $request, string $id)
    {
        // TODO: Validasi dan perbarui data program penyaluran.
    }

    public function destroy(string $id)
    {
        // TODO: Hapus data program penyaluran.
    }
}
