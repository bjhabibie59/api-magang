<?php

namespace App\Interfaces;

use App\Interfaces\Base\CreateInterface;
use App\Interfaces\Base\FindInterface;
use App\Interfaces\Base\GetAllInterface;
use App\Interfaces\Base\UpdateInterface;

interface AttendanceInterface extends CreateInterface, FindInterface, GetAllInterface, UpdateInterface
{
    public function findTodayByStudent(string $studentId);
    public function findByStudent(string $studentId, array $relations = []);
}
