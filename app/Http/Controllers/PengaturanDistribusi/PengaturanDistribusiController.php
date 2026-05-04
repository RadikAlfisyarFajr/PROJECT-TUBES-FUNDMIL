<?php

namespace App\Http\Controllers\PengaturanDistribusi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PengaturanDistribusiController extends Controller
{
    public function index()
    {
        return view('admin.pengaturan-distribusi.pengaturan-distribusi-index');
    }

    public function create()
    {
        return view('admin.pengaturan-distribusi.pengaturan-distribusi-create');
    }

    public function store(Request $request)
    {
        // TODO: Validasi dan simpan pengaturan distribusi.
    }

    public function show(string $id)
    {
        return view('admin.pengaturan-distribusi.pengaturan-distribusi-show', compact('id'));
    }

    public function edit(string $id)
    {
        return view('admin.pengaturan-distribusi.pengaturan-distribusi-edit', compact('id'));
    }

    public function update(Request $request, string $id)
    {
        // TODO: Validasi dan perbarui pengaturan distribusi.
    }

    public function destroy(string $id)
    {
        // TODO: Hapus pengaturan distribusi.
    }
}
