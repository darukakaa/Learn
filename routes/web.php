<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MateriController;
use App\Http\Controllers\DataSiswaController;
use App\Http\Controllers\ModulController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing');
});

// Route::middleware(['auth'])->group(function () {
//     Route::resource('materi', MateriController::class);
// });

// routes/web.php

// use App\Http\Controllers\MateriController;

Route::middleware(['auth'])->group(function () {
    Route::get('/materi', [MateriController::class, 'index'])->name('materi.index');
    Route::get('/materi/create', [MateriController::class, 'create'])->name('materi.create');
    Route::post('/materi', [MateriController::class, 'store'])->name('materi.store');
    Route::get('/materi/{materi}/edit', [MateriController::class, 'edit'])->name('materi.edit');
    Route::put('/materi/{materi}', [MateriController::class, 'update'])->name('materi.update');
    Route::delete('/materi/{materi}', [MateriController::class, 'destroy'])->name('materi.destroy');
});


// Route to list moduls and show the form to add a new modul
Route::get('/modul', [ModulController::class, 'index'])->name('modul.index');

// Route to handle the form submission for adding a new modul
Route::post('/modul', [ModulController::class, 'store'])->name('modul.store');

// Route to handle the form submission for updating an existing modul
Route::put('/modul/{modul}', [ModulController::class, 'update'])->name('modul.update');

// Route to handle the deletion of a modul
Route::delete('/modul/{modul}', [ModulController::class, 'destroy'])->name('modul.destroy');



Route::get('/data-siswa', [DataSiswaController::class, 'index'])->name('data-siswa');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified','rolemanager:user'])->name('dashboard');

Route::get('/admin/dashboard', function () {
    return view('admin');
})->middleware(['auth', 'verified','rolemanager:admin'])->name('admin');

Route::get('guru/dashboard', function () {
    return view('guru');
})->middleware(['auth', 'verified','rolemanager:guru'])->name('guru');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';
