<?php

namespace App\Interfaces;

interface AttendanceInterface extends BaseInterface
{
    public function findByStudentAndDate(string $studentId, string $date);
    public function findByStudent(string $studentId, array $relations = []);
    public function checkOut(string $id, array $data);
}
