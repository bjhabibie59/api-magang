<?php

namespace App\Interfaces\Base;

interface GetAllInterface
{
    public function getAll(array $relations = []);
}
