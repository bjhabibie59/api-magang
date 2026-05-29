<?php

namespace App\Repositories;

use App\Interfaces\AttendanceInterface;
use App\Models\Attendance;

class AttendanceRepository extends BaseRepository implements AttendanceInterface
{
    public function __construct(Attendance $model)
    {
        parent::__construct($model);
    }

    public function findTodayByStudent(string $studentId)
    {
        return $this->model
            ->where('student_id', $studentId)
            ->whereDate('date', today())
            ->first();
    }

    public function findByStudent(string $studentId, array $relations = [])
    {
        return $this->model
            ->with($relations)
            ->where('student_id', $studentId)
            ->orderByDesc('date')
            ->get();
    }
}
