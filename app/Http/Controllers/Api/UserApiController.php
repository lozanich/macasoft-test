<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\UserApiRequest;
use \App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserApiController extends Controller
{
    public function index() {
        $users = User::get();
        return response()->json($users);
    }


    public function update(User $user, Request $request)
    {
        $user->fill($request->all());
        $user->save();

        return response()->json($user->toArray());
    }

    public function store(UserApiRequest $request)
    {
        $user = User::make($request->all());
        $user->save();
        return response()->json($user->toArray());
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return response()->json(['success' => 'Usuario eliminado correctamente']);
    }
}
