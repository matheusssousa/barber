<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Servico;

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
}
