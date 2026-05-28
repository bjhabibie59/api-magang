<?php

namespace App\Interfaces;

interface BaseInterface
{
    public function findAll(array $relations = []);
    public function findById(string $id, array $relations = []);
    public function create(array $data);
    public function update(string $id, array $data);
    public function delete(string $id): bool;
}
