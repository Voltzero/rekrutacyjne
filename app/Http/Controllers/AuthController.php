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
        'email' => 'required|string|email|unique:users',
        'password' => 'required|string',
    ];

    private const SIGNUP_VALIDATION_MESSAGES = [
        'name.required' => 'Please provide name',
        'email.unique' => 'Email already exists',
        'email.required' => 'Please provide email',
        'password.required' => 'Please provide password',
    ];

    private const LOGIN_VALIDATION_RULES = [
        'email' => 'required|string|email',
        'password' => 'required|string',
    ];

    private const LOGIN_VALIDATION_MESSAGES = [
        'email.required' => 'Please provide email',
        'password.required' => 'Please provide password',
    ];

    private const TOKEN_NAME = 'API Token';

    private const TOKEN_TYPE = 'Bearer';

    public function signup(Request $request, User $userModel): JsonResponse
    {
        $errorMessages = $this->validateRequest(
            $request->all(),
            self::SIGNUP_VALIDATION_RULES,
            self::SIGNUP_VALIDATION_MESSAGES);

        if ($errorMessages) {
            return response()->json([
                'message' => 'Bad Request',
                'errors' => $errorMessages
            ], 400);
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
                'token' => $token->plainTextToken,
                'token_type' => self::TOKEN_TYPE,
            ],
            201
        );
    }

    public function login(Request $request): JsonResponse
    {
        $errorMessages = $this->validateRequest(
            $request->all(),
            self::LOGIN_VALIDATION_RULES,
            self::LOGIN_VALIDATION_MESSAGES);

        if ($errorMessages) {
            return response()->json([
                'message' => 'Bad Request',
                'errors' => $errorMessages
            ], 400);
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

    private function validateRequest(array $params, array $rules, array $messages): array
    {
        $validator = Validator($params, $rules, $messages);

        return $validator->messages()->all();
    }
}
