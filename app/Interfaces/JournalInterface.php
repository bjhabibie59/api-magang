<?php

namespace App\Interfaces;

use App\Interfaces\Base\CreateInterface;
use App\Interfaces\Base\DeleteInterface;
use App\Interfaces\Base\FindInterface;
use App\Interfaces\Base\GetAllInterface;
use App\Interfaces\Base\UpdateInterface;

interface JournalInterface extends CreateInterface, DeleteInterface, FindInterface, GetAllInterface, UpdateInterface
{
    public function findByStudent(string $studentId, array $relations = []);
    public function findByStudentAndId(string $studentId, string $id);
    public function existsByStudentAndDate(string $studentId, string $date): bool;
}
