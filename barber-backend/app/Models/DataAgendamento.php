<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DataAgendamento extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['data', 'agendamento_id'];

    public function agendamentos()
    {
        return $this->belongsTo(Agendamento::class);
    }
}
