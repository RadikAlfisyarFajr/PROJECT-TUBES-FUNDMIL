<?php

use App\Http\Controllers\ProfilInstansi\ProfilInstansiController;
use Illuminate\Support\Facades\Route;

Route::post('profil-instansi/rekening', [ProfilInstansiController::class, 'storeRekening'])
    ->name('profil-instansi.rekening.store');
Route::put('profil-instansi/rekening/{rekening}', [ProfilInstansiController::class, 'updateRekening'])
    ->name('profil-instansi.rekening.update');
Route::delete('profil-instansi/rekening/{rekening}', [ProfilInstansiController::class, 'destroyRekening'])
    ->name('profil-instansi.rekening.destroy');
Route::post('profil-instansi/notifikasi/read', [ProfilInstansiController::class, 'markNotificationsRead'])
    ->name('profil-instansi.notifications.read');

Route::resource('profil-instansi', ProfilInstansiController::class)
    ->names('profil-instansi');
