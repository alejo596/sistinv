<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dispositivo extends Model
{
    use HasFactory;
    protected $fillable = [
    'tipo_dispositivo_id', 
    'marca_id',
    'modelo_id',
    'procesador_id',
    'ram_id',
    'almacenamiento_id',
    'sistema_operativo_id',
    'numero_serie',
    'numero_inventario',
    'estado_id',
    'year',
    'unidad_id'
];
     function tipoDispositivo()
    {
        return $this->belongsTo(TipoDispositivo::class);
    }
    function marca()
    {
        return $this->belongsTo(Marca::class);
    }
     function modelo()
    {
        return $this->belongsTo(Modelo::class);
    }
     function procesador()
    {
        return $this->belongsTo(Procesador::class);
    }
     function ram()
    {
        return $this->belongsTo(Ram::class);
    }
     function almacenamiento()
    {
        return $this->belongsTo(Almacenamiento::class);
    }
     function sistemaOperativo()
    {
        return $this->belongsTo(SistemaOperativo::class);
    }
    function estado()
    {
        return $this->belongsTo(Estado::class);
    }
     function unidad()
    {
        return $this->belongsTo(Unidad::class);
    }
}
