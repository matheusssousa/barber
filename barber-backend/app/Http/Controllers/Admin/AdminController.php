<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Http\Requests\StoreAdminRequest;
use App\Http\Requests\UpdateAdminRequest;
use App\Http\Requests\UpdatePasswordRequest;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
      /**
     * Create a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(StoreAdminRequest $request)
    {
        $admin = new Admin([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $admin->save();

        return response()->json(['message' => 'Administrador criado com sucesso!', 'admin' => $admin], 201);
    }

    public function update(UpdateAdminRequest $request, $id)
    {
        $admin = Admin::findOrFail($id);

        if (auth()->user()->id != $id) {
            return response()->json(['message' => 'Acesso não autorizado'], 404);
        }

        $admin->fill($request->only(['name', 'email']));
        $admin->save();

        return response()->json(['message' => 'Administrador atualizado com sucesso', 'admin' => $admin], 200);
    }

    public function updatePassword(UpdatePasswordRequest $request, $id){
        $admin = Admin::findOrFail($id);

        if (auth()->user()->id != $id) {
            return response()->json(['message' => 'Acesso não autorizado'], 404);
        }

        $admin->password = Hash::make($request->password);
        $admin->save();

        return response()->json(['message' => 'Senha alterada com sucesso.', 'admin' => $admin], 200);
    }
}
