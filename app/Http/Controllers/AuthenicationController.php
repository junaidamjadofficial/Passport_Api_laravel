<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthenicationController extends Controller
{
    public function register(Request $request){
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'confirmation_password' => 'required|same:password|min:8',
        ]);
        $user=User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make( $request->password), 
        ]);

        $token=$user->createToken('User_Register_token')->accessToken;
        
        return response()->json([
            'token' => $token
        ]);

    }
    public function login(Request $request){
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        $user=User::where('email',$request->email)->first();
        if(!$user){
            return response()->json([
                'message' => 'User does not exists!'
            ]);
        }
        elseif(!Hash::check($request->password,$user->password)){
            return response()->json([
                'message' => 'Password incorrect!'
            ]);
        }
        $token=$user->createToken('User_login_token')->accessToken;
        return response()->json([
            'login_user_token' => $token,
            'message' => 'you are login'
        ]);

    }
    public function logout(Request $request){
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Logged out successfully!!'
        ]);
    }
}
