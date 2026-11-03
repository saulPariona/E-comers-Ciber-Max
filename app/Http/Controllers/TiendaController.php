<?php

namespace App\Http\Controllers;

use App\Support\CatalogoDemo;
use Illuminate\View\View;

class TiendaController extends Controller
{
    public function home(): View
    {
        return view('tienda.home', [
            'categorias' => CatalogoDemo::categorias(),
            'beneficios' => CatalogoDemo::beneficios(),
            'bombas' => CatalogoDemo::bombasDeLaSemana(),
            'masVendidos' => CatalogoDemo::masVendidos(),
            'ultimosVistos' => CatalogoDemo::ultimosVistos(),
        ]);
    }
}
