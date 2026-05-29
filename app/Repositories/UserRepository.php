<?php

namespace App\Repositories;

use App\Interfaces\UserInterface;
use App\Models\User;

class UserRepository extends BaseRepository implements UserInterface
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function findByEmail(string $email)
    {
        return $this->model->where('email', $email)->first();
    }

    public function findWithRoles(string $id)
    {
        return $this->model
            ->with(['admin', 'teacher', 'student'])
            ->findOrFail($id);
    }
}
