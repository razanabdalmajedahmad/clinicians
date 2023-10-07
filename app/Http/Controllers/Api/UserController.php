<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function login(Request $request){
        $validator = Validator::make($request->toArray(), [
            'email'=>'required|email',
            'password'=>'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->all(),
                'state' => false
            ]);
        }
        if (!Auth::attempt($request->only(['email', 'password']))) {
            return response()->json([
                'message' => 'Credentials do not match',
                'state' => false
            ]);
        }else{
            $user=Auth::user();
            $token = $user->createToken('Api Token of' . $user->name)->plainTextToken;
            return response()->json([
                'message' => 'Logged in successfully',
                'state' =>true,
                'data'=>[
                    'user'=>$user,
                    'token'=>$token
                ]
            ]);
        }
    }
}
