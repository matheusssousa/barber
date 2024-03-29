<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Pacote;

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
}
