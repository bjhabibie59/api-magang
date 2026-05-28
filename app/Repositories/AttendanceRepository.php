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

    public function findByStudentAndDate(string $studentId, string $date)
    {
        return $this->model
            ->where('student_id', $studentId)
            ->whereDate('date', $date)
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

    public function checkOut(string $id, array $data)
    {
        $record = $this->findById($id);
        $record->update($data);
        return $record->fresh();
    }
}
