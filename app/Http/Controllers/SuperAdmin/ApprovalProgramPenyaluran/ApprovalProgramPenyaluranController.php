<?php

namespace App\Http\Controllers\SuperAdmin\ApprovalProgramPenyaluran;

use App\Http\Controllers\Controller;

class ApprovalProgramPenyaluranController extends Controller
{
    public function index()
    {
        return view('superadmin.approval-program-penyaluran.approval-program-penyaluran-index');
    }

    public function show(string $id)
    {
        return view('superadmin.approval-program-penyaluran.approval-program-penyaluran-show', compact('id'));
    }

    public function approve(string $id)
    {
        // TODO: Setujui program penyaluran.
    }

    public function reject(string $id)
    {
        // TODO: Tolak program penyaluran.
    }
}
