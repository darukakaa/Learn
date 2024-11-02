<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DataSiswaController extends Controller
{
    /**
     * Display the data siswa page.
     */
    public function index()
    {

        // $studentCount = User::where('role', 2)->count();
        // Fetch only users with the role '2'
        $users = User::where('role', 2)->get();

        return view('data-siswa', compact('users'));
    }
}

