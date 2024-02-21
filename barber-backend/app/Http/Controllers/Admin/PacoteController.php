<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pacote;
use App\Http\Requests\StorePacoteRequest;
use App\Http\Requests\UpdatePacoteRequest;
use Illuminate\Support\Facades\Storage;

class PacoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pacotes = Pacote::paginate(10);

        return response()->json($pacotes, 200);
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
    public function store(StorePacoteRequest $request)
    {
        $pacote = new Pacote();

        $pacote->nome = $request->nome;
        $pacote->descricao = $request->descricao;
        $pacote->valor = $request->valor;

        if ($request->file('foto')) {
            $foto_urn = $request->file('foto')->store('fotos', 'public');
            $pacote->foto = $foto_urn;
        }

        $pacote->save();

        return response()->json(['message' => 'Pacote criado com sucesso.', $pacote], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $pacote = Pacote::findOrFail($id);

        return response()->json($pacote, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pacote $pacote)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePacoteRequest $request, $id)
    {
        $pacote = Pacote::findOrFail($id);
        
        $pacote->fill($request->only(['nome', 'descricao', 'valor']));
        // UPDATE DA FOTO
        if ($request->file('foto')) {
            if (!empty($pacote->foto) && Storage::disk('public')->exists($pacote->foto)) {
                Storage::disk('public')->delete($pacote->foto);
            }
            $foto_urn = $request->file('foto')->store('fotos','public');
            $pacote->foto = $foto_urn;
        }
        $pacote->update();

        return response()->json(['message' => 'Pacote atualizado com sucesso.', $pacote], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $pacote = Pacote::findOrFail($id);
        $pacote->delete();

        return response()->json(['message' => 'Pacote excluído com sucesso'], 200);
    }

    /**
     * Restaurar um arquivo deletado.
     */
    public function restore($id)
    {
        $pacote = Pacote::withTrashed()->findOrFail($id);
        $pacote->restore();

        return response()->json(['message' => 'Pacote restaurado com sucesso', $pacote], 200);
    }

    /**
     * Deletar um arquivo permanentemente.
     */
    public function forceDelete($id)
    {
        $pacote = Pacote::withTrashed()->findOrFail($id);
        if ($pacote->foto) {
            Storage::disk('public')->delete($pacote->foto);
        }
        $pacote->forceDelete();

        return response()->json(['message' => 'Pacote excluído permanentemente com sucesso'], 200);
    }
}
