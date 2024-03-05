<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Exception;
use Hash;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function create(RegisterUserRequest $request)
    {
        try {

            $user = User::where('email', $request->email)->first();

            if(!empty($user)) {
                throw new Exception('User exists with email', 400);
            }

            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            return response()->json([
                'status' => true,
                'message' => 'User is created successfully',
            ], 201);
        } catch(Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], $e->getCode());
        }
    }

}
