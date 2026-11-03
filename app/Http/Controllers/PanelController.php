<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class PanelController extends Controller
{
    public function admin(): View
    {
        return view('panel.dashboard', ['area' => 'Administración']);
    }

    public function ventas(): View
    {
        return view('panel.dashboard', ['area' => 'Ventas']);
    }

    public function almacen(): View
    {
        return view('panel.dashboard', ['area' => 'Almacén']);
    }
}
