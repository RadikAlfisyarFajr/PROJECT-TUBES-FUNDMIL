<?php

namespace App\Http\Controllers\SuperAdmin\Nishab;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NishabController extends Controller
{
    public function index()
    {
        return view('superadmin.nishab.nishab-index');
    }

    public function create()
    {
        return view('superadmin.nishab.nishab-create');
    }

    public function store(Request $request)
    {
        // TODO: Validasi dan simpan data nishab.
    }

    public function show(string $id)
    {
        return view('superadmin.nishab.nishab-show', compact('id'));
    }

    public function edit(string $id)
    {
        return view('superadmin.nishab.nishab-edit', compact('id'));
    }

    public function update(Request $request, string $id)
    {
        // TODO: Validasi dan perbarui data nishab.
    }

    public function destroy(string $id)
    {
        // TODO: Hapus data nishab.
    }
}
