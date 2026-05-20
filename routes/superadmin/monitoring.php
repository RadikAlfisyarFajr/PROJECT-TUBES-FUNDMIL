<?php

use App\Http\Controllers\SuperAdmin\Monitoring\MonitoringController;
use Illuminate\Support\Facades\Route;

Route::get('superadmin/monitoring', [MonitoringController::class, 'index'])
    ->name('superadmin.monitoring.index');
