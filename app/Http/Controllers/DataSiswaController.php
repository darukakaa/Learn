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
        // Fetch only users with the role '2' and order by the latest created_at
        $users = User::where('role', 2)
            ->orderBy('created_at', 'desc') // Ordering by created_at in descending order
            ->get();

        return view('data-siswa', compact('users'));
    }
}
