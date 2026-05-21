<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Logistica extends Model
{
    protected $fillable = ['pedido_id', 'estado_envio', 'fecha_estimada_entrega'];
}
