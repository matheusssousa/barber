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
        'valor_total'
    ];

    public function user()
    {
        $this->belongsTo(User::class);
    }
    public function pacote()
    {
        $this->belongsTo(Pacote::class);
    }
    public function corte()
    {
        $this->belongsTo(Corte::class);
    }
    public function servico()
    {
        $this->belongsToMany(AgendamentoServicos::class, 'agendamento_servicos', 'agendamento_id', 'servico_id')->withPivot('id');
    }
}
