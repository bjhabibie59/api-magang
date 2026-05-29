<?php

namespace App\Providers;

use App\Interfaces\AttendanceInterface;
use App\Interfaces\JournalInterface;
use App\Interfaces\UserInterface;
use App\Repositories\AttendanceRepository;
use App\Repositories\JournalRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $bindings = [
            UserInterface::class       => UserRepository::class,
            // \App\Interfaces\AdminInterface::class      => \App\Repositories\AdminRepository::class,
            // \App\Interfaces\TeacherInterface::class    => \App\Repositories\TeacherRepository::class,
            // \App\Interfaces\StudentInterface::class    => \App\Repositories\StudentRepository::class,
            // \App\Interfaces\InternshipInterface::class => \App\Repositories\InternshipRepository::class,
            AttendanceInterface::class => AttendanceRepository::class,
            JournalInterface::class    => JournalRepository::class,
            // \App\Interfaces\ReportInterface::class     => \App\Repositories\ReportRepository::class,
            // \App\Interfaces\AssessmentInterface::class => \App\Repositories\AssessmentRepository::class,
        ];

        foreach ($bindings as $interface => $repository) {
            $this->app->bind($interface, $repository);
        }
    }
}
