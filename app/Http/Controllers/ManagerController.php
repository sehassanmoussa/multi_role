<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Manager;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class ManagerController extends Controller
{
    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        $request['password']=Hash::make($request['password']);
        $request['remember_token'] = Str::random(10);
        $user = User::createUser($request->toArray() , config('permission_levels.manager'));
        Manager::createManager($request , $user->id);
        $token = $user->createToken('Laravel Password Grant Client')->accessToken;
        $response = ['token' => $token];
        return response($response, 200);
    }
    public function managerDetails()
    {
        $manager = Manager::with('user')->where('user_id',auth('users-api')->user()->id )->first();
        return response()->json($manager ,  200);
    }
}
