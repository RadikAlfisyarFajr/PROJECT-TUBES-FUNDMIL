<?php

namespace App\Http\Controllers\SuperAdmin\ApprovalAdminInstansi;

use App\Http\Controllers\Controller;

class ApprovalAdminInstansiController extends Controller
{
    public function index()
    {
        return view('superadmin.approval-admin-instansi.approval-admin-instansi-index');
    }

    public function show(string $id)
    {
        return view('superadmin.approval-admin-instansi.approval-admin-instansi-show', compact('id'));
    }

    public function approve(string $id)
    {
        // TODO: Setujui akun admin instansi dan hubungkan ke data instansi.
    }

    public function reject(string $id)
    {
        // TODO: Tolak akun admin instansi.
    }
}
