<?php

namespace App\Repositories;

use App\Interfaces\JournalInterface;
use App\Models\Journal;
use Override;

class JournalRepository extends BaseRepository implements JournalInterface
{
    public function __construct(Journal $model)
    {
        parent::__construct($model);
    }

    public function findByStudent(string $studentId, array $relations = [])
    {
        return $this->model
            ->with($relations)
            ->where('student_id', $studentId)
            ->orderByDesc('date')
            ->get();
    }

    public function findByStudentAndId(string $studentId, string $id)
    {
        return $this->model
            ->where('student_id', $studentId)
            ->where('id', $id)
            ->firstOrFail();
    }

    #[Override]
    public function existsByStudentAndDate(string $studentId, string $date): bool
    {
        return $this->model
            ->where('student_id', $studentId)
            ->where('date', $date)
            ->exists();
    }
}
