<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\GuruDashboardController;
use App\Http\Controllers\SiswaDashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MateriController;
use App\Http\Controllers\LearningController;
use App\Http\Controllers\KuisTugasController;
use App\Http\Controllers\KuisController;
use App\Http\Controllers\QuestionsController;
use App\Http\Controllers\TugasController;
use App\Http\Controllers\DataSiswaController;
use App\Http\Controllers\ModulController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing');
});

// Route::middleware(['auth'])->group(function () {
//     Route::resource('materi', MateriController::class);


// use App\Http\Controllers\MateriController;

Route::middleware(['auth'])->group(function () {
    Route::get('/materi', [MateriController::class, 'index'])->name('materi.index');
    Route::get('/materi/create', [MateriController::class, 'create'])->name('materi.create');
    Route::post('/materi', [MateriController::class, 'store'])->name('materi.store');
    Route::get('/materi/{materi}/edit', [MateriController::class, 'edit'])->name('materi.edit');
    Route::put('/materi/{materi}', [MateriController::class, 'update'])->name('materi.update');
    Route::delete('/materi/{materi}', [MateriController::class, 'destroy'])->name('materi.destroy');
});

// routes/web.php
Route::get('/learning', [LearningController::class, 'index'])->name('learning.index');
Route::post('/learning/store', [LearningController::class, 'store'])->name('learning.store');
Route::delete('/learning/{id}', [LearningController::class, 'destroy'])->name('learning.destroy');
Route::get('/learning/{id}', [LearningController::class, 'show'])->name('learning.show');

Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->middleware(['auth', 'verified', 'rolemanager:admin'])->name('admin');

Route::resource('learning', LearningController::class);


// Route to list moduls and show the form to add a new modul
Route::get('/modul', [ModulController::class, 'index'])->name('modul.index');

// Route to handle the form submission for adding a new modul
Route::post('/modul', [ModulController::class, 'store'])->name('modul.store');

// Route to handle the form submission for updating an existing modul
Route::put('/modul/{modul}', [ModulController::class, 'update'])->name('modul.update');

// Route to handle the deletion of a modul
Route::delete('/modul/{modul}', [ModulController::class, 'destroy'])->name('modul.destroy');

// Route to handle kuis tugas
Route::get('/kuis-tugas', [KuisTugasController::class, 'index'])->name('kuis-tugas.index');
Route::resource('kuis', KuisController::class);
Route::get('/kuis/{id}', [KuisController::class, 'show'])->name('kuis.show');
Route::get('kuis/{id}', [KuisController::class, 'show'])->name('kuis.show');
Route::get('/kuis', [KuisController::class, 'index'])->name('kuis.index');
Route::post('kuis/{id}/questions', [QuestionsController::class, 'store'])->name('questions.store');


Route::get('/tugas', [TugasController::class, 'index'])->name('tugas.index');
Route::post('/tugas', [TugasController::class, 'store'])->name('tugas.store');
Route::get('/tugas/{id}', [TugasController::class, 'show'])->name('tugas.show');
Route::post('/tugas/{id}/upload', [TugasController::class, 'upload'])->name('tugas.upload');
Route::delete('/tugas/{id}', [TugasController::class, 'destroy'])->name('tugas.destroy');


Route::post('/tugas/validate/{id}', [TugasController::class, 'validate'])->name('tugas.validate');
Route::post('/tugas/unvalidate/{id}', [TugasController::class, 'unvalidate'])->name('tugas.unvalidate');






Route::get('/data-siswa', [DataSiswaController::class, 'index'])->name('data-siswa');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified', 'rolemanager:user'])->name('dashboard');

Route::get('/dashboard', [SiswaDashboardController::class, 'index'])->middleware(['auth', 'verified', 'rolemanager:user'])->name('dashboard');

Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->middleware(['auth', 'verified', 'rolemanager:admin'])->name('admin');

Route::get('guru/dashboard', function () {
    return view('guru');
})->middleware(['auth', 'verified', 'rolemanager:guru'])->name('guru');

Route::get('/guru/dashboard', [GuruDashboardController::class, 'index'])->middleware(['auth', 'verified', 'rolemanager:guru'])->name('guru');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__ . '/auth.php';
