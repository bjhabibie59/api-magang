<?php

namespace App\Http\Controllers;

use App\Helpers\Api;
use App\Http\Handlers\AuthHandler;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function __construct(
        private readonly AuthHandler $handler
    ) {}

    public function login(LoginRequest $request)
    {
        try {
            $result = $this->handler->login($request->validated());

            return Api::success(
                data: [
                    'user'  => new UserResource($result['user']),
                    'role'  => $result['role'],
                    'token' => $result['token'],
                ],
                message: 'Login berhasil',
            );
        } catch (ValidationException $e) {
            return Api::validationError(
                errors: $e->errors(),
                message: 'Login gagal',
            );
        }
    }

    public function logout(Request $request)
    {
        $this->handler->logout($request->user());

        return Api::success(message: 'Logout berhasil');
    }

    public function me(Request $request)
    {
        $user = $this->handler->me($request->user());

        return Api::success(
            data: new UserResource($user),
            message: 'Data profil berhasil diambil',
        );
    }
}
