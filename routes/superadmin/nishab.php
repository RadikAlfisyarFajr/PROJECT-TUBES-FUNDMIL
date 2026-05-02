<?php

use App\Http\Controllers\SuperAdmin\Nishab\NishabController;
use Illuminate\Support\Facades\Route;

Route::resource('superadmin/nishab', NishabController::class)
    ->names('superadmin.nishab');
