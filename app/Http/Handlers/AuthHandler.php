<?php

namespace App\Http\Handlers;

use App\Helpers\Enum\RoleEnum;
use App\Interfaces\UserInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthHandler
{
    public function __construct(
        private readonly UserInterface $userRepository
    ) {}

    public function login(array $data): array
    {
        $user = $this->userRepository->findByEmail($data['email']);

        if (!$user || !Hash::check($data['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Kredensial tidak valid.'],
            ]);
        }

        // Eager load relasi role
        $user->loadMissing(['admin', 'teacher', 'student']);
        $role = $user->getRole();

        if ($role === 'unknown') {
            throw ValidationException::withMessages([
                'email' => ['Akun belum memiliki role.'],
            ]);
        }

        // Hapus token lama, buat token baru
        $user->tokens()->delete();
        $token = $user->createToken("auth_token_{$role}")->plainTextToken;

        return [
            'user'  => $user,
            'role'  => $role,
            'token' => $token,
        ];
    }

    public function logout($user): void
    {
        $user->tokens()->delete();
    }

    public function me($user)
    {
        return $this->userRepository->findWithRoles($user->id);
    }
}
