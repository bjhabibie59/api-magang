<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $bindings = [
            // \App\Interfaces\UserInterface::class       => \App\Repositories\UserRepository::class,
            // \App\Interfaces\AdminInterface::class      => \App\Repositories\AdminRepository::class,
            // \App\Interfaces\TeacherInterface::class    => \App\Repositories\TeacherRepository::class,
            // \App\Interfaces\StudentInterface::class    => \App\Repositories\StudentRepository::class,
            // \App\Interfaces\InternshipInterface::class => \App\Repositories\InternshipRepository::class,
            \App\Interfaces\AttendanceInterface::class => \App\Repositories\AttendanceRepository::class,
            // \App\Interfaces\JournalInterface::class    => \App\Repositories\JournalRepository::class,
            // \App\Interfaces\ReportInterface::class     => \App\Repositories\ReportRepository::class,
            // \App\Interfaces\AssessmentInterface::class => \App\Repositories\AssessmentRepository::class,
        ];

        foreach ($bindings as $interface => $repository) {
            $this->app->bind($interface, $repository);
        }
    }
}
