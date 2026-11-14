<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class CuentaController extends Controller
{
    public function mostrar(): View
    {
        return view('cuenta');
    }
}
