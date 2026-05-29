<?php

namespace App\Http\Controllers;

use App\Helpers\Api;
use App\Http\Handlers\AuthHandler;  // ← dikoreksi
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function __construct(
        private readonly AuthHandler $handler
    ) {}

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        try {
            $result = $this->handler->login($validated);

            return Api::success(
                data: [
                    'user'  => $result['user'],
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
            data: $user,
            message: 'Data profil berhasil diambil',
        );
    }
}
