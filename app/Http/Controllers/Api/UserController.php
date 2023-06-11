<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //User Register API
    public function register(Request $request)
    {
        //validate
        $request->validate([
            "name" => "required",
            "email" => "required|email|unique:users",
            "phone_number" => "required",
            'password' => 'required|between:8,255|confirmed',
        ]);

        //create user data + save
        $user = new User();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
        $user->password = bcrypt($request->password);

        $user->save();

        return response()->json([
            "status" => 1,
            "message" => "User Registered Successfully"

        ], 200);
    }

    //User Login API
    public function login(Request $request)
    {
        //Validate
        $request->validate([
            "email" => "required|email",
            "password" => "required"
        ]);

        //Verify user + token
        if(!$token = auth()->attempt([
            "email" => $request->email, "password" => $request->password
        ])) {

            return response()->json([
                "status" => 0,
                "message" => "Invalid Credentials"
            ]);
        };

        //Send response
        return response()->json([
            "status" => 1,
            "message" => "Logged in Successful",
            "access_token" => $token
        ]);
    }

    //User Profile API
    public function profile()
    {
        $user_data = auth()->user();

        return response()->json([
            "status" => 1,
            "message" => "User profile data",
            "data" => $user_data
        ]);
    }

    //User Logout API
    public function logout()
    {
        auth()->logout();

        return response()->json([
            "status" => 1,
            "message" => "User Logged Out"
        ]);
    }
}
