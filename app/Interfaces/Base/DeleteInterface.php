<?php

namespace App\Interfaces\Base;

interface DeleteInterface
{
    public function delete(string $id): bool;
}
