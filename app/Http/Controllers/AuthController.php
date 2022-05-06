<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Validator;

class AuthController extends Controller
{
    private const SIGNUP_VALIDATION_RULES = [
        'name' => 'required|string',
        'email' => 'required|string|email',
        'password' => 'required|string',
    ];

    private const LOGIN_VALIDATION_RULES = [
        'email' => 'required|string|email',
        'password' => 'required|string',
    ];

    private const TOKEN_NAME = 'API Token';

    private const TOKEN_TYPE = 'Bearer';

    public function signup(Request $request, User $userModel): JsonResponse
    {
        $validator = Validator($request->all(), self::SIGNUP_VALIDATION_RULES);
        if ($validator->fails()) {
            return response()->json(['message' => 'Bad Request'], 400);
        }

        $newUser = $userModel->create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        $newUser->save();

        $token = $newUser->createToken(self::TOKEN_NAME);

        return response()->json(
            [
                'message' => 'Successfully created user!',
                'token' => $token->accessToken,
                'token_type' => self::TOKEN_TYPE,
            ],
            201
        );
    }

    public function login(Request $request): JsonResponse
    {
        $validator = Validator($request->all(), self::LOGIN_VALIDATION_RULES);
        if ($validator->fails()) {
            return response()->json(['message' => 'Bad Request'], 400);
        }

        $login = $request->input('email');
        $password = $request->input('password');

        $credentials = array(
            'email' => $login,
            'password' => $password
        );

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $user = $request->user();

        $token = $user->createToken(self::TOKEN_NAME);

        return response()->json(
            [
                'message' => 'Successfully logged in!',
                'token' => $token->plainTextToken,
                'token_type' => self::TOKEN_TYPE,
            ]
        );
    }
}
