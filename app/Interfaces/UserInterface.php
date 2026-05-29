<?php

namespace App\Interfaces;

interface UserInterface extends BaseInterface
{
    public function findByEmail(string $email);
    public function findWithRoles(string $id);
}
