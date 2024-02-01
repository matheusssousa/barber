<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contexto;
use App\Http\Requests\StoreContextoRequest;
use App\Http\Requests\UpdateContextoRequest;

class ContextoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contexto = Contexto::all();

        return response()->json($contexto, 200);
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
    public function store(StoreContextoRequest $request)
    {
        $contexto = new Contexto();
        $contexto->horario_abertura = $request->horario_abertura;
        $contexto->horario_fechamento = $request->horario_fechamento;
        $contexto->localizacao = $request->localizacao;
        $contexto->contato = $request->contato;
        $contexto->instagram = $request->instagram;
        $contexto->facebook = $request->facebook;
        $contexto->tiktok = $request->tiktok;
        $contexto->whatsapp = $request->whatsapp;
        $contexto->save();

        return response()->json(['message' => 'Contexto criado com sucesso.', $contexto], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $contexto = Contexto::findOrFail($id);

        return response()->json($contexto, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contexto $contexto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContextoRequest $request, $id)
    {
        $contexto = Contexto::findOrFail($id);
        $contexto->fill($request->all());
        $contexto->update();

        return response()->json(['message' => 'Atualização feita.', $contexto], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $contexto = Contexto::findOrFail($id);
        $contexto->delete();

        return response()->json(['message' => 'Contexto deletado.'], 200);
    }
}
