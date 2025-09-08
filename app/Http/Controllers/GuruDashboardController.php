<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Learning;
use App\Models\Materi;
use App\Models\Tugas;
use App\Models\Materiv2;
use App\Models\TesSoal;
use Illuminate\Http\Request;

class GuruDashboardController extends Controller
{
    public function index()
    {
        // Count the number of users with role '2'
        $jumlahSiswa = User::where('role', 2)->count();
        $jumlahLearning = Learning::all()->count();
        $jumlahMateri = Materi::all()->count();
        $jumlahMateriv2 = Materiv2::count();
        $jumlahTugas = Tugas::all()->count();
        $jumlahTes = TesSoal::all()->count();

        return view('guru', compact('jumlahSiswa', 'jumlahMateriv2', 'jumlahLearning', 'jumlahMateri', 'jumlahTugas', 'jumlahTes'));
    }
}
