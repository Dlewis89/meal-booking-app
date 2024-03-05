<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use App\Http\Requests\User\RegisterRequest;
use App\Http\Requests\User\LoginRequest;
use App\Models\User;
use Exception;
use Hash;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function store(RegisterRequest $request) : JsonResponse
    {
        try {

            $user = User::where('email', $request->email)->first();

            if(!empty($user)) {
                throw new Exception('User exists with email', 400);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $user->syncRoles($request->role);

            return response()->json([
                'status' => true,
                'message' => 'User is created successfully',
            ], 201);

        } catch (CustomException $e) {

            report($e);
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], $e->getCode());

        }  catch(Exception $e) {

            report($e);
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function login(LoginRequest $request)
    {
        try {

            $user = User::where('email', $request->email)->first();

            if(empty($user) || !Hash::check($request->password, $user->password)) {
                throw new Exception('User email or password is incorrect', 400);
            }

            return response()->json([
                'status' => true,
                'message' => 'User has logged in successfully',
                'user' => array_merge($user->toArray(), [
                    'token' => $user->createToken(config('app.name'))->plainTextToken
                ])
            ], 200);

        } catch (CustomException $e) {

            report($e);
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], $e->getCode());

        } catch(Exception $e) {

            report($e);
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], $e->getCode());

        }

    }

}
