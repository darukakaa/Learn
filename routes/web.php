<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AnswerV2Controller;
use App\Http\Controllers\GuruDashboardController;
use App\Http\Controllers\SiswaDashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MateriController;
use App\Http\Controllers\LearningController;
use App\Http\Controllers\KelompokController;
use App\Http\Controllers\KuisTugasController;
use App\Http\Controllers\KuisController;
use App\Http\Controllers\KuisV2Controller;
use App\Http\Controllers\QuestionV2Controller;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QuestionsController;
use App\Http\Controllers\TugasController;
use App\Http\Controllers\DataSiswaController;
use App\Http\Controllers\ModulController;
use App\Http\Controllers\ResultsController;
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


// route kuis
Route::post('/questions/{kuis}', [QuestionController::class, 'store'])->name('questions.store');
Route::post('/questions/submit', [QuestionsController::class, 'submit'])->name('questions.submit');
Route::get('/kuis/{kuis}', [KuisController::class, 'show'])->name('kuis.show');
Route::post('/kuis/{kuis}/submit', [KuisController::class, 'submitAnswers'])->name('questions.submit');


//kuisv2
Route::get('/kuisv2', [KuisV2Controller::class, 'index'])->name('kuisv2.index');
Route::post('/kuisv2', [KuisV2Controller::class, 'store'])->name('kuisv2.store');
Route::delete('/kuisv2/{id}', [KuisV2Controller::class, 'destroy'])->name('kuisv2.destroy');
Route::put('kuisv2/{id}', [KuisV2Controller::class, 'update'])->name('kuisv2.update');
Route::get('/kuisv2/{id}', [Kuisv2Controller::class, 'show'])->name('kuisv2.show');
Route::get('/start-kuis/{id}', [Kuisv2Controller::class, 'start'])->name('start.quiz');
Route::get('/kuisv2', [Kuisv2Controller::class, 'index'])->name('kuisv2.index');
Route::post('/kuisv2/{kuis_id}/questions', [QuestionV2Controller::class, 'store'])->name('questions.store');
Route::get('/kuisv2/questions/{kuis_id}', [QuestionV2Controller::class, 'show'])->name('questions.show');


Route::post('/answers', [AnswerV2Controller::class, 'store'])->name('answers_v2.store');

//result
Route::get('/results/{id}', [ResultsController::class, 'show'])->name('results.show');

//score
Route::post('/answers_v2/score', [AnswerV2Controller::class, 'score'])->name('answers_v2.score');

Route::get('/answers_v2/score/{id}', [AnswerV2Controller::class, 'showScore'])->name('answers_v2.score');


Route::get('/kuisv2/score/{id}', [AnswerV2Controller::class, 'score'])->name('answers_v2.score');

Route::get('/answers_v2/score/{quizId}', [AnswerV2Controller::class, 'showScore'])->name('answers_v2.showScore');


// Rute untuk menampilkan halaman belajar
Route::get('/learning/{learning}', [LearningController::class, 'show'])->name('learning.show');

Route::get('learning/{learning}', [LearningController::class, 'show'])->name('learning.show');






//learning stage1
// Route::post('/learning/store-stage1', [LearningController::class, 'storeStage1'])->name('learning.storeStage1');
Route::post('/learning/{id}/stage1', [LearningController::class, 'storeStage1'])->name('learning.stage1.store');

//stage1 result
// Route::post('/learning/{learningStage1Id}/stage1/result', [LearningController::class, 'storeStage1Result'])
//     ->name('learning.stage1.result.store');

Route::post('learning/{learningStage1Id}/stage1/result', [LearningController::class, 'storeStage1Result'])->name('learning.stage1.result.store');




//learning stage2

Route::get('/learning/{learning}/stage/2', [LearningController::class, 'showStage2'])->name('learning.stage2');
//kelompok
Route::get('/kelompok/create', [KelompokController::class, 'create'])->name('kelompok.create');
Route::post('/learning/{learningId}/stage/{stageId}/kelompok', [KelompokController::class, 'store'])->name('kelompok.store');



Route::get('/learning/{learningId}/stage/{stageId}', [LearningController::class, 'show'])->name('learning.show');
Route::post('/learning/{learningId}/stage/{stageId}/kelompok', [KelompokController::class, 'store'])->name('kelompok.store');

Route::get('/learning/{learningId}/stage/{stageId}', [KelompokController::class, 'show'])->name('kelompok.show');

// Route::get('/learning/{learningId}/{stageId}', [LearningController::class, 'showLearning'])->name('learning.show');

Route::post('learning/{learningId}/stage/{stageId}/kelompok', [KelompokController::class, 'store'])->name('kelompok.store');

Route::get('/kelompok/{learningId}/{stageId}', [KelompokController::class, 'showForm'])->name('kelompok.show');

Route::get('/learning/{learningId}/stage/{stageId}', [LearningController::class, 'showStage'])->name('learning.stage');

// Route untuk menampilkan Stage 2
Route::get('/learning/{learningId}/stage2', [LearningController::class, 'showStage2'])->name('learning.stage2');

// Route untuk menyimpan kelompok
Route::post('/learning/{learningId}/kelompok', [LearningController::class, 'storeKelompok'])->name('kelompok.store');

Route::post('/kelompok/store/{learningId}/{stageId}', [KelompokController::class, 'store'])->name('kelompok.store');
Route::get('/learning/{learningId}/stage2', [LearningController::class, 'showStage2'])->name('learning.stage2');

Route::delete('/kelompok/{id}', [KelompokController::class, 'destroy'])->name('kelompok.destroy');





// nilai
Route::get('/kuisv2/nilai/{id}', function ($id) {
    return view('nilai.index', ['kuisId' => $id]);
})->name('kuisv2.nilai');

Route::get('/kuisv2/nilai/{id}', [KuisV2Controller::class, 'showScore'])->name('kuisv2.nilai');



Route::post('/kuisv2/submit-jawaban', [AnswerV2Controller::class, 'store'])->name('answers_v2.store');
Route::post('/kuisv2/score', [AnswerV2Controller::class, 'score'])->name('answers_v2.score');

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
