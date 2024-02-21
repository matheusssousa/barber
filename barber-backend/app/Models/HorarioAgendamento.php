<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HorarioAgendamento extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['horario'];

    public function agendamentos()
    {
        return $this->hasMany(Agendamento::class);
    }
}
