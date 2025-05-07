<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;


class PoliticasController extends Controller
{

    public function privacidad()
    {
        return Inertia::render('Public/Politicas/Privacidad');
    }
    
    public function cookies()
    {
        return Inertia::render('Public/Politicas/Cookies');
    }

    public function aviso_legal()
    {
        return Inertia::render('Public/Politicas/AvisoLegal');
    }

    
}
