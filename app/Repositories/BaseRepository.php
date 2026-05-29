<?php

namespace App\Repositories;

use App\Interfaces\BaseInterface;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements BaseInterface
{
    public function __construct(protected Model $model) {}

    public function getAll(array $relations = [])
    {
        return $this->model->with($relations)->get();
    }

    public function findById(string $id, array $relations = [])
    {
        return $this->model->with($relations)->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(string $id, array $data)
    {
        $record = $this->findById($id);
        $record->update($data);
        return $record->fresh();
    }

    public function delete(string $id): bool
    {
        return $this->findById($id)->delete();
    }
}
