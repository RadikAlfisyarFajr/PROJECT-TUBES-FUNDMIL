<?php

namespace App\Http\Controllers\SuperAdmin\ApprovalAdminInstansi;

use App\Http\Controllers\Controller;
use App\Models\User;

class ApprovalAdminInstansiController extends Controller
{
    public function index()
    {
        $pendingUsers = User::where('role', 'admin_instansi')
            ->where('status', 'pending')
            ->orderByDesc('created_at')
            ->get();

        return view('superadmin.approval-admin-instansi.approval-admin-instansi-index', compact('pendingUsers'));
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
