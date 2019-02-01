<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\UserApiRequest;
use \App\User;
use Carbon\Carbon;
use Faker\Provider\Image;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UserApiController extends Controller
{
    public function index()
    {
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
        /*if($request->get('user_photo'))
        {
            $imageName = time().'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('images'), $imageName);
        }


        dd($imageName);*/

        $user = User::make($request->all());
        $user->user_photo = 'test.png';
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
