<?php

namespace App\Http\Controllers\ProfilInstansi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfilInstansiController extends Controller
{
    public function index()
    {
        return view('admin.profil-instansi.profil-instansi-index');
    }

    public function create()
    {
        return view('admin.profil-instansi.profil-instansi-create');
    }

    public function store(Request $request)
    {
        // TODO: Validasi dan simpan data profil instansi.
    }

    public function show(string $id)
    {
        return view('admin.profil-instansi.profil-instansi-show', compact('id'));
    }

    public function edit(string $id)
    {
        return view('admin.profil-instansi.profil-instansi-edit', compact('id'));
    }

    public function update(Request $request, string $id)
    {
        // TODO: Validasi dan perbarui data profil instansi.
    }

    public function destroy(string $id)
    {
        // TODO: Hapus data profil instansi.
    }
}
