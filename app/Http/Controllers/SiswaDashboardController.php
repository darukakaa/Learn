<?php

namespace App\Http\Controllers;

use App\Models\User;

use App\Models\Modul;
use App\Models\Learning;
use App\Models\Materi;
use App\Models\Tugas;
use Illuminate\Http\Request;

class SiswaDashboardController extends Controller
{
    public function index()
    {
        $jumlahLearning = Learning::all()->count();
        $jumlahModul = Modul::all()->count();
        $jumlahMateri = Materi::all()->count();
        $jumlahTugas = Tugas::all()->count();

        return view('dashboard', compact('jumlahModul', 'jumlahLearning', 'jumlahMateri', 'jumlahTugas'));
    }
}
