<?php

namespace App\Http\Controllers\SuperAdmin\Monitoring;

use App\Http\Controllers\Controller;

class MonitoringController extends Controller
{
    public function index()
    {
        return view('superadmin.monitoring.monitoring-index');
    }
}
