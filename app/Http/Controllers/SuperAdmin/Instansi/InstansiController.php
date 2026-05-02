<?php

namespace App\Http\Controllers\SuperAdmin\Instansi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InstansiController extends Controller
{
    public function index()
    {
        return view('superadmin.instansi.instansi-index');
    }

    public function create()
    {
        return view('superadmin.instansi.instansi-create');
    }

    public function store(Request $request)
    {
        // TODO: Validasi dan simpan data instansi.
    }

    public function show(string $id)
    {
        return view('superadmin.instansi.instansi-show', compact('id'));
    }

    public function edit(string $id)
    {
        return view('superadmin.instansi.instansi-edit', compact('id'));
    }

    public function update(Request $request, string $id)
    {
        // TODO: Validasi dan perbarui data instansi.
    }

    public function destroy(string $id)
    {
        // TODO: Hapus atau nonaktifkan data instansi.
    }
}
