<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KuisTugasController extends Controller
{
    public function index()
    {
        return view('kuis-tugas.index');
    }
}

