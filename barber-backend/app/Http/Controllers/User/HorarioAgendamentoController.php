<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Agendamento;
use App\Models\HorarioAgendamento;
use Illuminate\Http\Request;

class HorarioAgendamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function horariosdisponiveis($data)
    {
        // Obter horários disponíveis para agendamento
        $horariosDisponiveis = HorarioAgendamento::all();

        // Obter horários já agendados para o dia atual
        $horariosAgendados = Agendamento::whereDate('data', $data)
            ->pluck('horario_id')
            ->toArray();

        // Filtrar os horários disponíveis, excluindo aqueles já agendados
        $horariosNaoAgendados = $horariosDisponiveis->filter(function ($horario) use ($horariosAgendados) {
            return !in_array($horario->id, $horariosAgendados);
        });

        return response()->json($horariosNaoAgendados, 200);
    }
}
