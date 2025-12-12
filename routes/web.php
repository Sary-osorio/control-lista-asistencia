<?php

use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\GrupoController;
use App\Http\Controllers\MiembroController;
use App\Http\Controllers\ProfileController;
use App\Livewire\Grupos;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::match(['GET', 'POST'], '/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('miembro')->middleware('auth')->group(function () {
    Route::match(['GET', 'POST'], '/', [MiembroController::class, 'index'])->name('miembro.index');
    Route::post('/create', [MiembroController::class, 'create'])->name('miembro.create');
    Route::patch('/update', [MiembroController::class, 'update'])->name('miembro.update');
});

Route::prefix('grupo')->middleware('auth')->group(function () {
    Route::match(['GET', 'POST'], '/', [GrupoController::class, 'index'])->name('grupo.index');
    Route::post('/create', [GrupoController::class, 'create'])->name('grupo.create');
    Route::patch('/update', [GrupoController::class, 'update'])->name('grupo.update');
});

Route::prefix('asistencia')->middleware('auth')->group(function () {
    Route::get('/', [AsistenciaController::class, 'index'])->name('asistencia.index');
    Route::get('/listado/{param?}', [AsistenciaController::class, 'listadoAsistencia'])->name('asistencia.listado');
    Route::get('/anterior/{param?}', [AsistenciaController::class, 'asistenciaAnterior'])->name('asistencia.anterior');
    Route::post('/create', [AsistenciaController::class, 'create'])->name('asistencia.create');
    // Route::post('/listado/search', [AsistenciaController::class, 'searchAsistencia'])->name('asistencia.search');
});

// Route::prefix('grupos')->middleware('auth')->group(function () {
//     Route::post('/create', [Grupos::class, 'store'])->name('grupos.store');
// });


require __DIR__.'/auth.php';
