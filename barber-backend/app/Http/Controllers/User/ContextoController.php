<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Contexto;
use Illuminate\Http\Request;

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
}
