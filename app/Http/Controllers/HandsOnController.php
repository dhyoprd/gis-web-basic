<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HandsOnController extends Controller
{
    public function tugas1()
    {
        return view('tugas-handson-1');
    }

    public function tugas2()
    {
        return view('tugas-handson-2');
    }
} 