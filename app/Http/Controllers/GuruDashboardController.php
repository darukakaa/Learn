<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Learning;
use App\Models\Modul;
use App\Models\Materi;
use App\Models\Tugas;
use Illuminate\Http\Request;

class GuruDashboardController extends Controller
{
    public function index()
    {
        // Count the number of users with role '2'
        $jumlahSiswa = User::where('role', 2)->count();
        $jumlahLearning = Learning::all()->count();
        $jumlahModul = Modul::all()->count();
        $jumlahMateri = Materi::all()->count();
        $jumlahTugas = Tugas::all()->count();

        return view('guru', compact('jumlahSiswa', 'jumlahLearning', 'jumlahModul', 'jumlahMateri', 'jumlahTugas'));
    }
}
