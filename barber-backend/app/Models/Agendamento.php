<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Agendamento extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'user_id',
        'pacote_id',
        'corte_id',
        'valor_total',
        'horario_id',
        'data'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function data()
    {
        return $this->hasMany(DataAgendamento::class);
    }
    public function horario()
    {
        return $this->belongsTo(HorarioAgendamento::class);
    }
    public function pacote()
    {
        return $this->belongsTo(Pacote::class);
    }
    public function corte()
    {
        return $this->belongsTo(Corte::class);
    }
    public function servico()
    {
        return $this->belongsToMany(AgendamentoServicos::class, 'agendamento_servicos', 'agendamento_id', 'servico_id')->withPivot('id');
    }
}
