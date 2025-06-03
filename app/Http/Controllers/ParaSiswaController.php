<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ParaSiswaController extends Controller
{
    public function parasiswa()
    {
        $siswa = User::role('Siswa')
                    ->select('name', 'email')
                    ->orderBy('name')
                    ->get();
                    
        return view('siswa.parasiswa', compact('siswa'));
    }
}