<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function signUp(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string'
        ]);

        $input = $request->all();

        $user = new User([
            'first_name' => $input['first_name'],
            'last_name' => $input['last_name'],
            'email' => $input['email'],
            'password' => app('hash')->make($input['password'])
        ]);
        $user->save();

        $token =  $user->createToken('docline')->accessToken;

        return response()->json([
            'user' => new UserResource($user),
            'token' => $token,
            'message' => 'Successfully created user!'
        ], 201);
    }
}
