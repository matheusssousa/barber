<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAgendamentoRequest;
use App\Http\Requests\UpdateAgendamentoRequest;
use App\Models\Agendamento;
use App\Models\Corte;
use App\Models\Pacote;
use App\Models\Servico;
use Illuminate\Http\Request;

class AgendamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $agendamentos = Agendamento::paginate(10);

        return response()->json($agendamentos, 200);
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
    public function store(StoreAgendamentoRequest $request)
    {
        //
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $agendamento = Agendamento::findOrFail($id);

        return response()->json($agendamento, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Agendamento $agendamento)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAgendamentoRequest $request, $id)
    {
        $agendamento = Agendamento::findOrFail($id);
        $agendamento->data = $request->data;
        $agendamento->valor_total = 0;

        // Se existir um pacote no agendamento, salva o agendamento e encerra a criação
        if ($request->pacote_id) {
            $agendamento->pacote_id = $request->pacote_id;
            $agendamento->valor_total = Pacote::where('id', $request->pacote_id)->value('valor');
            $agendamento->save();
            return response()->json(['message' => 'Agendamento feito com sucesso.', 'agendamento' => $agendamento], 200);
        }

        if ($request->corte_id) {
            $agendamento->corte_id = $request->corte_id;
            $agendamento->valor_total += Corte::where('id', $request->corte_id)->value('valor');
        }

        if ($request->servicos) {
            // Exclui os servicos relacionados ao antigo agendamento.
            $agendamento->servicos()->detach();
            foreach ($request->servicos as $key => $servico) {
                $agendamento->valor_total += Servico::where('id', $servico)->value('valor');
                $agendamento->servicos()->attach($servico);
            }
        }

        $agendamento->save();

        return response()->json(['message' => 'Agendamento atualizado com sucesso.', $agendamento], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $agendamento = Agendamento::findOrFail($id);

        if ($agendamento->servicos()) {
            $agendamento->servicos()->detach();
        }

        $agendamento->delete();
        return response()->json(['message' => 'Agendamento cancelado com sucesso.'], 200);
    }

    /**
     * Restaurar um arquivo deletado.
     */
    public function restore($id)
    {
        $agendamento = Agendamento::withTrashed()->findOrFail($id);
        $agendamento->servicos()->restore();
        $agendamento->restore();

        return response()->json(['message' => 'Agendamento restaurado com sucesso', $agendamento], 200);
    }
}
