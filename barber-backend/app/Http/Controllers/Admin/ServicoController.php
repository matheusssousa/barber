<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Servico;
use App\Http\Requests\StoreServicoRequest;
use App\Http\Requests\UpdateServicoRequest;
use Illuminate\Support\Facades\Storage;

class ServicoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $servicos = Servico::paginate(10)->get();

        return response()->json(['message' => 'Servicos cadastrados.', 'servicos' => $servicos], 200);
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
    public function store(StoreServicoRequest $request)
    {
        $servico = new Servico();

        $servico->nome = $request->nome;
        $servico->descricao = $request->descricao;
        $servico->valor = $request->valor;

        if ($request->file('foto')) {
            $foto_urn = $request->file('foto')->store('fotos', 'public');
            $servico->foto = $foto_urn;
        }

        $servico->save();

        return response()->json(['message' => 'Servico criado com sucesso.', 'servico' => $servico], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Servico $servico, $id)
    {
        $servico = Servico::findOrFail($id);

        return response()->json(['message' => 'Consulta feita com sucesso.', 'servico' => $servico], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Servico $servico)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateServicoRequest $request, Servico $servico, $id)
    {
        $servico = Servico::findOrFail($id);

        $servico->fill($request->only(['nome', 'descricao', 'valor']));
        // UPDATE DA FOTO
        if ($request->file('foto')) {
            if (Storage::disk('public')->exists($servico->foto)) {
                Storage::disk('public')->delete($servico->foto);
            }
            $foto_urn = $request->file('foto')->store('fotos','public');
            $servico->foto = $foto_urn;
        }
        $servico->update();

        return response()->json(['message' => 'Servico atualizado com sucesso.', 'servico' => $servico], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Servico $servico, $id)
    {
        $servico = Servico::findOrFail($id);
        $servico->softDeletes();

        return response()->json(['message' => 'Servico excluído com sucesso'], 200);
    }

    /**
     * Restaurar um arquivo deletado.
     */
    public function restore($id)
    {
        $servico = Servico::withTrashed()->findOrFail($id);
        $servico->restore();

        return response()->json(['message' => 'Servico restaurado com sucesso', 'servico' => $servico], 200);
    }

    /**
     * Deletar um arquivo permanentemente.
     */
    public function forceDelete($id)
    {
        $servico = Servico::withTrashed()->findOrFail($id);
        if ($servico->foto) {
            Storage::disk('public')->delete($servico->foto);
        }
        $servico->forceDelete();

        return response()->json(['message' => 'Servico excluído permanentemente com sucesso'], 200);
    }
}
