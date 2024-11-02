<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Modul;
use App\Models\Materi;
use App\Models\Tugas;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Count the number of users with role '2'
        $jumlahSiswa = User::where('role', 2)->count();
        $jumlahModul = Modul::all()->count();
        $jumlahMateri = Materi::all()->count();
        $jumlahTugas = Tugas::all()->count();

        return view('admin', compact('jumlahSiswa', 'jumlahModul', 'jumlahMateri', 'jumlahTugas'));
    }
}
