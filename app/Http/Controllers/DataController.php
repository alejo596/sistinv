<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TipoDispositivo;
use App\Models\Marca;
use App\Models\Modelo;
use App\Models\Procesador;
use App\Models\Ram;
use App\Models\Almacenamiento;
use App\Models\SistemaOperativo;
use App\Models\Unidad;
class DataController extends Controller
{
    public function index()
{
  return response()->json([
    'tiposDispositivos' => TipoDispositivo::all(),
    'marcas' => Marca::all(),
    'modelos' => Modelo::all(),
    'procesadores' => Procesador::all(),
    'rams' => Ram::all(),
    'almacenamientos' => Almacenamiento::all(),
    'sistemasOperativos' => SistemaOperativo::all(),
    'unidades' => Unidad::all(),
  ]);
}
}
