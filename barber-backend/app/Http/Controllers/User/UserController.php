<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
      /**
     * Create a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(StoreUserRequest $request)
    {
        $user = new User([
            'name' => $request->name,
            'phone' => $request->phone,
        ]);

        $user->save();

        return response()->json(['message' => 'Usuário criado com sucesso!', 'user' => $user], 201);
    }

    public function update(UpdateUserRequest $request, $id)
    {
        $user = User::findOrFail($id);

        if (auth()->user()->id != $id) {
            return response()->json(['message' => 'Acesso não autorizado'], 404);
        }

        $user->fill($request->all());
        $user->save();

        return response()->json(['message' => 'Usuário atualizado com sucesso', 'user' => $user], 200);
    }

}
