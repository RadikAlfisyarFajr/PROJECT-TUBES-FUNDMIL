<?php

namespace App\Http\Controllers\SuperAdmin\Pengguna;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PenggunaController extends Controller
{
    public function index()
    {
        return view('superadmin.pengguna.pengguna-index');
    }

    public function create()
    {
        return view('superadmin.pengguna.pengguna-create');
    }

    public function store(Request $request)
    {
        // TODO: Validasi dan simpan akun pengguna.
    }

    public function show(string $id)
    {
        return view('superadmin.pengguna.pengguna-show', compact('id'));
    }

    public function edit(string $id)
    {
        return view('superadmin.pengguna.pengguna-edit', compact('id'));
    }

    public function update(Request $request, string $id)
    {
        // TODO: Validasi dan perbarui akun pengguna.
    }

    public function destroy(string $id)
    {
        // TODO: Blokir atau hapus akun pengguna.
    }
}
