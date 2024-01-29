<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Servico extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'nome',
        'descricao',
        'foto',
        'valor',
    ];

    public function agendamentos()
    {
        $this->belongsToMany(AgendamentoServicos::class, 'agendamento_servicos', 'servico_id', 'agendamento_id')->withPivot('id');
    }
}
