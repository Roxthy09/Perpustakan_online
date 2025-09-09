<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PetugasController extends Controller
{
    public function index()
    {
        return view('dashboard.petugas', [
            'user' => Auth::user()
        ]);
    }
}
