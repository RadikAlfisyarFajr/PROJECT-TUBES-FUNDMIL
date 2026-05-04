<?php

use App\Http\Controllers\ProfilInstansi\ProfilInstansiController;
use Illuminate\Support\Facades\Route;

Route::resource('profil-instansi', ProfilInstansiController::class)
    ->names('profil-instansi');
