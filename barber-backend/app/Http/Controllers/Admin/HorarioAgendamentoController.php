<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HorarioAgendamento;
use App\Http\Requests\StoreHorarioAgendamentoRequest;
use App\Http\Requests\UpdateHorarioAgendamentoRequest;

class HorarioAgendamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $horarios = HorarioAgendamento::paginate(10);

        return response()->json($horarios, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreHorarioAgendamentoRequest $request)
    {
        $horario = new HorarioAgendamento();
        $horario->horario = $request->horario;
        $horario->save();

        return response()->json($horario, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $horario = HorarioAgendamento::findOrFail($id);

        return response()->json($horario, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HorarioAgendamento $horarioAgendamento)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHorarioAgendamentoRequest $request, $id)
    {
        $horario = HorarioAgendamento::findOrFail($id);
        $horario->fill($request->all());
        $horario->update();

        return response()->json(['message' => 'Atualizado com sucesso.', $horario], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $horario = HorarioAgendamento::findOrFail($id);
        $horario->delete();

        return response()->json(['message' => 'Horario excluido.'], 200);
    }

    /**
     * Restaurar um arquivo deletado.
     */
    public function restore($id)
    {
        $horario = HorarioAgendamento::withTrashed()->findOrFail($id);
        $horario->restore();

        return response()->json(['message' => 'Horario restaurado com sucesso', $horario], 200);
    }

    /**
     * Deletar um arquivo permanentemente.
     */
    public function forceDelete($id)
    {
        $horario = HorarioAgendamento::withTrashed()->findOrFail($id);
        $horario->forceDelete();

        return response()->json(['message' => 'Horario excluído permanentemente com sucesso'], 200);
    }
}
