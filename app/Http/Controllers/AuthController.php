<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    private const SIGNUP_VALIDATION_RULES = [
        'name' => 'required|string',
        'email' => 'required|string|email|unique:users',
        'password' => 'required|string',
    ];

    private const LOGIN_VALIDATION_RULES = [
        'email' => 'required|string|email',
        'password' => 'required|string',
    ];

    private const VALIDATION_MESSAGES = [
        'required' => ':attribute field is required',
        'unique' => 'Email already exists',
    ];

    private const TOKEN_NAME = 'API Token';

    private const TOKEN_TYPE = 'Bearer';

    public function signup(Request $request, User $userModel): JsonResponse
    {
        $validator = Validator::make(
            $request->all(),
            self::SIGNUP_VALIDATION_RULES,
            self::VALIDATION_MESSAGES);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Bad Request',
                'errors' => $validator->errors()
            ], 400);
        }

        $newUser = $userModel->create($validator->validated());

        $newUser->save();

        $token = $newUser->createToken(self::TOKEN_NAME);

        return response()->json(
            [
                'message' => 'Successfully created user!',
                'token' => $token->plainTextToken,
                'token_type' => self::TOKEN_TYPE,
            ],
            201
        );
    }

    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make(
            $request->all(),
            self::LOGIN_VALIDATION_RULES,
            self::VALIDATION_MESSAGES);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Bad Request',
                'errors' => $validator->errors()
            ], 400);
        }

        $credentials = $validator->validated();

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
