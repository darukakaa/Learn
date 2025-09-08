<?php

namespace App\Http\Controllers;

use App\Models\User;


use App\Models\Learning;
use App\Models\Materi;
use App\Models\Materiv2;
use App\Models\Tugas;
use Illuminate\Http\Request;

class SiswaDashboardController extends Controller
{
    public function index()
    {
        $jumlahLearning = Learning::all()->count();
        $jumlahMateriv2 = Materiv2::count();
        $jumlahMateri = Materi::all()->count();
        $jumlahTugas = Tugas::all()->count();

        return view('dashboard', compact('jumlahLearning', 'jumlahMateriv2', 'jumlahMateri', 'jumlahTugas'));
    }
}
