<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class routeController extends Controller
{
    public function public() {
        return inertia::render('home');
    }
    public function dashboard() {
        return inertia::render('dashboard');
    }
    public function detailMobil() {
        return inertia::render('detail_mobil');
    }
    public function user(){
        return inertia::render('detail_user');
    }
}
