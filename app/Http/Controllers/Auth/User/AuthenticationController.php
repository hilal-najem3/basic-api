<?php

namespace App\Http\Controllers\Auth\User;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use Validator;

class AuthenticationController extends Controller
{
    public function authenticate(Request $request)
    {
        $data = $request->all();

        $this->validator($data)->validate();

        $credentials = $request->only('email', 'password');

        $token = null;

        try {
            if (!Auth::attempt($credentials)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid credentials!'
                ], 400);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Couldn\'t login!',
                'error' => $e->getMessage()
            ], 500);
        }

        try {
            $user = Auth::user();

            if(!$user->active) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Couldn\'t login!'
                ], 400);
            }

            $data = [
                'status' => 'success',
                'message' => 'Login complete!',
                'user' => $user,
                'roles' => $user->roles()->get(),
                'token' => $user->createToken(env('APP_NAME'))->accessToken
            ];

            return response()->json(compact('data'));
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Couldn\'t login!',
                'error' => $e->getMessage()
            ], 400);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Couldn\'t login!'
        ], 400);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);
    }
}
