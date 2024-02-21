<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Agendamento;
use App\Http\Requests\StoreAgendamentoRequest;
use App\Http\Requests\UpdateAgendamentoRequest;
use App\Models\Corte;
use App\Models\DataAgendamento;
use App\Models\Pacote;
use App\Models\Servico;

class AgendamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $agendamentos = Agendamento::where('user_id', auth()->user()->id)->paginate(10);

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
        // Verificar se já existe um agendamento para o mesmo dia e horário
        $existingAgendamento = Agendamento::where('data', $request->data)
            ->where('horario_id', $request->horario_id)
            ->first();

        if ($existingAgendamento) {
            return response()->json(['error' => 'Já existe um agendamento para o mesmo dia e horário.'], 400);
        }

        $agendamento = new Agendamento();
        $agendamento->user_id = auth()->user()->id;
        $agendamento->horario_id = $request->horario_id;
        // O valor total é declarado antes para ser incrementado posteriormente no backend, para prevenir que mandem uma requisição com valor adulterado.
        $agendamento->valor_total = 0;

        // Se existir um pacote no agendamento, salva o agendamento e encerra a criação
        if ($request->pacote_id) {
            $agendamento->pacote_id = $request->pacote_id;
            $agendamento->valor_total = Pacote::where('id', $request->pacote_id)->value('valor');
            $dataAgendamento = new DataAgendamento(['data' => $request->data]);
            $agendamento->data()->save($dataAgendamento);
            $agendamento->save();
            return response()->json(['message' => 'Agendamento feito com sucesso.', $agendamento], 200);
        }

        if ($request->corte_id) {
            $agendamento->corte_id = $request->corte_id;
            $agendamento->valor_total += Corte::where('id', $request->corte_id)->value('valor');
        }

        $agendamento->save();

        $dataAgendamento = new DataAgendamento(['data' => $request->data]);
        $agendamento->data()->save($dataAgendamento);

        if ($request->servicos) {
            foreach ($request->servicos as $key => $servico) {
                $agendamento->valor_total += Servico::where('id', $servico)->value('valor');
                $agendamento->servicos()->attach($servico);
            }
        }

        return response()->json(['message' => 'Agendamento salvo com sucesso', $agendamento], 200);
    }


    /**
     * Display the specified resource.
     */
    public function show(Agendamento $agendamento, $id)
    {
        $agendamento = Agendamento::findOrFail($id);

        if ($agendamento->user_id != auth()->user()->id) {
            return response()->json(['message' => 'Não pode ser acessado.'], 201);
        }

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

        if ($agendamento->user_id != auth()->user()->id) {
            return response()->json(['message' => 'Não pode ser acessado.'], 201);
        }

        $agendamento->data = $request->data;
        $agendamento->valor_total = 0;

        // Se existir um pacote no agendamento, salva o agendamento e encerra a criação
        if ($request->pacote_id) {
            $agendamento->pacote_id = $request->pacote_id;
            $agendamento->valor_total = Pacote::where('id', $request->pacote_id)->value('valor');
            $agendamento->save();
            return response()->json(['message' => 'Agendamento feito com sucesso.', $agendamento], 200);
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

        if ($agendamento->user_id != auth()->user()->id) {
            return response()->json(['message' => 'Não pode ser acessado.'], 201);
        }

        if ($agendamento->servicos()) {
            $agendamento->servicos()->detach();
        }

        $agendamento->delete();
        return response()->json(['message' => 'Agendamento cancelado com sucesso.'], 200);
    }
}
