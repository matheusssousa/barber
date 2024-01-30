<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Corte;

class CorteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cortes = Corte::paginate(10);

        return response()->json($cortes, 200);
    }
}
