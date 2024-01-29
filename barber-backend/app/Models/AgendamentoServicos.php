<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AgendamentoServicos extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'agendamento_id',
        'servico_id'
    ];
}
