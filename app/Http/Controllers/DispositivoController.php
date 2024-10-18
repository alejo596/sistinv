<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dispositivo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator; 
class DispositivoController extends Controller
{
    public function index()
    {
     $dispositivos = DB::table('dispositivos')
     ->select(
        'dispositivos.id',
        'tipo_dispositivos.nombre AS tipo_dispositivo',
        'marcas.nombre AS marca',
        'modelos.nombre AS modelo',
        'procesadors.nombre AS procesador',
        'rams.capacidad AS ram',
        'almacenamientos.capacidad AS almacenamiento',
        'sistema_operativos.nombre AS sistema_operativo',
        'dispositivos.numero_serie',
        'dispositivos.numero_inventario',
        'estados.nombre as estados',
        'dispositivos.year',
        'unidads.nombre as unidad'
    )
     ->join('tipo_dispositivos', 'dispositivos.tipo_dispositivo_id', '=', 'tipo_dispositivos.id')
     ->join('procesadors', 'dispositivos.procesador_id', '=', 'procesadors.id')
     ->join('modelos', 'dispositivos.modelo_id', '=', 'modelos.id')
     ->join('marcas', function ($join) {
        $join->on('dispositivos.marca_id', '=', 'marcas.id')
        ->on('modelos.marca_id', '=', 'marcas.id');
    })
     ->join('almacenamientos', 'dispositivos.almacenamiento_id', '=', 'almacenamientos.id')
     ->join('sistema_operativos', 'dispositivos.sistema_operativo_id', '=', 'sistema_operativos.id')
     ->join('rams', 'dispositivos.ram_id', '=', 'rams.id')
     ->join('estados', 'dispositivos.estado_id', '=', 'estados.id')
     ->leftjoin('unidads', 'dispositivos.unidad_id', '=', 'unidads.id')
     ->get();

     return response()->json($dispositivos);

 }
public function storeMasivo(Request $request)
{
    if ($request->hasFile('csv_file')) {
        $file = $request->file('csv_file');
        $data = array_map('str_getcsv', file($file->getRealPath()));
        array_shift($data); // Eliminar la primera fila si son encabezados

        foreach ($data as $row) {
            try {
                $tipoDispositivoId = $row[0];
                $marcaId = $row[1];
                $modeloId = $row[2];
                $procesadorId = $row[3];
                $ramId = $row[4];
                $almacenamientoId = $row[5];
                $sistemaOperativoId = $row[6];
                $numeroSerie = $row[7];
                $numeroInventario = $row[8];
                $unidad=$row[9];
                $estado=$row[10];

                // Validación
                $reglasValidacion = [
                    'tipo_dispositivo_id' => 'required|exists:tipo_dispositivos,id',
                    'marca_id' => 'required|exists:marcas,id',
                    'modelo_id' => 'required|exists:modelos,id',
                    'procesador_id' => 'required|exists:procesadors,id',
                    'ram_id' => 'required|exists:rams,id',
                    'almacenamiento_id' => 'required|exists:almacenamientos,id',
                    'sistema_operativo_id' => 'required|exists:sistema_operativos,id',
                    'numero_serie' => 'required|unique:dispositivos',
                    'numero_inventario' => 'required|unique:dispositivos',
                ];

                // Validación condicional según tipo de dispositivo
                if ($tipoDispositivoId == 1 || $tipoDispositivoId == 2) {
                    $reglasValidacion = array_merge($reglasValidacion, [
                        'procesador_id' => 'required|exists:procesadors,id',
                        'ram_id' => 'required|exists:rams,id',
                        'almacenamiento_id' => 'required|exists:almacenamientos,id',
                        'sistema_operativo_id' => 'required|exists:sistema_operativos,id',
                    ]);
                } else {
                    unset($reglasValidacion['procesador_id']);
                    unset($reglasValidacion['ram_id']);
                    unset($reglasValidacion['almacenamiento_id']);
                    unset($reglasValidacion['sistema_operativo_id']);
                }

                // Validar los datos de la fila
                $validator = Validator::make([
                    'tipo_dispositivo_id' => $tipoDispositivoId,
                    'marca_id' => $marcaId,
                    'modelo_id' => $modeloId,
                    'procesador_id' => $procesadorId,
                    'ram_id' => $ramId,
                    'almacenamiento_id' => $almacenamientoId,
                    'sistema_operativo_id' => $sistemaOperativoId,
                    'numero_serie' => $numeroSerie,
                    'numero_inventario' => $numeroInventario,
                ], $reglasValidacion);

                if ($validator->fails()) {
                    Log::error('Error de validación en el CSV: ' . $validator->errors()->first() . ' - Fila: ' . print_r($row, true));
                    continue; // Saltar a la siguiente fila si hay errores de validación
                }

                if (empty($numeroInventario)) {
                    $numeroInventario = 'INVPM' . date('Y') . $numeroSerie;
                }

                Dispositivo::create([
                    'tipo_dispositivo_id' => $tipoDispositivoId,
                    'marca_id' => $marcaId,
                    'modelo_id' => $modeloId,
                    'procesador_id' => $procesadorId,
                    'ram_id' => $ramId,
                    'almacenamiento_id' => $almacenamientoId,
                    'sistema_operativo_id' => $sistemaOperativoId,
                    'numero_serie' => $numeroSerie,
                    'numero_inventario' => $numeroInventario,
                    'estado_id' => $estado,                    
                    'year' => date('Y'),
                    'unidad_id'=>$unidad,
                ]);

            } catch (\ErrorException $e) {
                Log::error('Error al procesar el CSV: ' . $e->getMessage() . ' - Fila: ' . print_r($row, true));
                return response()->json(['message' => 'Error al procesar el archivo CSV'], 500);
            }
        }

        return response()->json(['message' => 'Productos guardados correctamente'], 201);
    }

    return response()->json(['message' => 'No se ha subido ningún archivo'], 400);
}
public function store(Request $request)
{
 $tipoDispositivoId = $request->input('tipo_dispositivo_id');

 $reglasValidacion = [
    'marca_id' => 'required|exists:marcas,id',
    'modelo_id' => 'required|exists:modelos,id',
    'numero_serie' => 'required|unique:dispositivos'

];

if ($tipoDispositivoId == 1 || $tipoDispositivoId == 2) {
    $reglasValidacion = array_merge($reglasValidacion, [
        'tipo_dispositivo_id' => 'required|exists:tipo_dispositivos,id',
        'procesador_id' => 'required|exists:procesadors,id',
        'ram_id' => 'required|exists:rams,id',
        'almacenamiento_id' => 'required|exists:almacenamientos,id',
        'sistema_operativo_id' => 'required|exists:sistema_operativos,id',
        'unidad_id' => 'required|exists:unidads,id',
    ]);
}

$request->validate($reglasValidacion);
$numeroInventario = $request->input('numero_inventario');

if (empty($numeroInventario)) {
    $numeroInventario = 'INVPM' . date('Y') . $request->input('numero_serie');
}
$producto = Dispositivo::create(array_merge($request->all(), [
        'estado_id' => 1, // Agregar estado 1
        'year' => date('Y'), // Agregar el año en curso
        'numero_inventario' => $numeroInventario,
    ]));

return response()->json($producto, 201);
}
}
