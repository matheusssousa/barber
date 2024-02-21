<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contexto extends Model
{
    use HasFactory;
    protected $fillable = [
        'horario_abertura',
        'horario_fechamento',
        'localizacao',
        'contato',
        'instagram',
        'facebook',
        'tiktok',
        'whatsapp',
    ];
}
