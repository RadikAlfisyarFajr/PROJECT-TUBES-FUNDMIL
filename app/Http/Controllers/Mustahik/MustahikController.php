<?php

namespace App\Http\Controllers\Mustahik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MustahikController extends Controller
{
    public function index()
    {
        return view('admin.mustahik.mustahik-index');
    }

    public function create()
    {
        return view('admin.mustahik.mustahik-create');
    }

    public function store(Request $request)
    {
        // TODO: Validasi dan simpan data mustahik.
    }

    public function show(string $id)
    {
        return view('admin.mustahik.mustahik-show', compact('id'));
    }

    public function edit(string $id)
    {
        return view('admin.mustahik.mustahik-edit', compact('id'));
    }

    public function update(Request $request, string $id)
    {
        // TODO: Validasi dan perbarui data mustahik.
    }

    public function destroy(string $id)
    {
        // TODO: Hapus data mustahik.
    }
}
