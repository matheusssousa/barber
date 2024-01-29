<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Corte;
use App\Http\Requests\StoreCorteRequest;
use App\Http\Requests\UpdateCorteRequest;
use Illuminate\Support\Facades\Storage;

class CorteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cortes = Corte::paginate(10);

        return response()->json(['message' => 'Cortes cadastrados.', 'cortes' => $cortes], 200);
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
    public function store(StoreCorteRequest $request)
    {
        $corte = new Corte();

        $corte->nome = $request->nome;
        $corte->descricao = $request->descricao;
        $corte->valor = $request->valor;

        if ($request->file('foto')) {
            $foto_urn = $request->file('foto')->store('fotos', 'public');
            $corte->foto = $foto_urn;
        }

        $corte->save();

        return response()->json(['message' => 'Corte criado com sucesso.', 'corte' => $corte], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Corte $corte, $id)
    {
        $corte = Corte::findOrFail($id);

        return response()->json(['message' => 'Consulta feita com sucesso.', 'corte' => $corte], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Corte $corte)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCorteRequest $request, Corte $corte, $id)
    {
        $corte = Corte::findOrFail($id);

        $corte->fill($request->only(['nome', 'descricao', 'valor']));
        // UPDATE DA FOTO
        if ($request->file('foto')) {
            if (Storage::disk('public')->exists($corte->foto)) {
                Storage::disk('public')->delete($corte->foto);
            }
            $foto_urn = $request->file('foto')->store('fotos','public');
            $corte->foto = $foto_urn;
        }
        $corte->update();

        return response()->json(['message' => 'Corte atualizado com sucesso.', 'corte' => $corte], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Corte $corte, $id)
    {
        $corte = Corte::findOrFail($id);
        $corte->softDeletes();

        return response()->json(['message' => 'Corte excluído com sucesso'], 200);
    }

    /**
     * Restaurar um arquivo deletado.
     */
    public function restore($id)
    {
        $corte = Corte::withTrashed()->findOrFail($id);
        $corte->restore();

        return response()->json(['message' => 'Corte restaurado com sucesso', 'corte' => $corte], 200);
    }

    /**
     * Deletar um arquivo permanentemente.
     */
    public function forceDelete($id)
    {
        $corte = Corte::withTrashed()->findOrFail($id);
        if ($corte->foto) {
            Storage::disk('public')->delete($corte->foto);
        }
        $corte->forceDelete();

        return response()->json(['message' => 'Corte excluído permanentemente com sucesso'], 200);
    }
}
