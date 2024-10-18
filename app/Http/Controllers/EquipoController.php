<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use Illuminate\Http\Request;

class EquipoController extends Controller
{
    public function index()
    {
        $equipos = Equipo::all();
        return view('equipos.index', compact('equipos'));
    }

    public function create()
    {
        return view('equipos.create');
    }

    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'nombre' => 'required',
            'descripcion' => 'required',
            'serial' => 'required|unique:equipos',
        ]);

        // Crear un nuevo equipo
        Equipo::create($request->all());

        return redirect()->route('equipos.index');
    }

    // ... métodos para editar, actualizar y eliminar
}