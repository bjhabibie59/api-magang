<?php

namespace App\Interfaces\Base;

interface FindInterface
{
    public function findById(string $id, array $relations = []);
}
