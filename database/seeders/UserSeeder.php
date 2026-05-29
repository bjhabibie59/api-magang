<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Internship;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ── Superadmin ──────────────────────────────────────────
        $superadmin = User::create([
            'name'     => 'Super Admin',
            'username' => 'superadmin',
            'email'    => 'superadmin@magnets.dev',
            'password' => Hash::make('password'),
        ]);

        Admin::create([
            'user_id' => $superadmin->id,
            'level'   => 'superadmin',
        ]);

        // ── Admin ────────────────────────────────────────────────
        $admin = User::create([
            'name'     => 'Admin',
            'username' => 'admin',
            'email'    => 'admin@magnets.dev',
            'password' => Hash::make('password'),
        ]);

        Admin::create([
            'user_id' => $admin->id,
            'level'   => 'admin',
        ]);

        // ── Teacher ──────────────────────────────────────────────
        $teacherUser = User::create([
            'name'     => 'Budi Santoso',
            'username' => 'budi.santoso',
            'email'    => 'teacher@magnets.dev',
            'password' => Hash::make('password'),
        ]);

        $teacher = Teacher::create([
            'user_id' => $teacherUser->id,
            'nip'     => '1234567890',
            'phone'   => '081234567890',
        ]);

        // ── Internship (butuh teacher) ───────────────────────────
        $internship = Internship::create([
            'teacher_id'   => $teacher->id,
            'company_name' => 'PT. Maju Bersama',
            'address'      => 'Jl. Raya Surabaya No. 123',
            'latitude'     => -7.250445,
            'longitude'    => 112.768845,
        ]);

        // ── Student ──────────────────────────────────────────────
        $studentUser = User::create([
            'name'     => 'Ani Rahayu',
            'username' => 'ani.rahayu',
            'email'    => 'student@magnets.dev',
            'password' => Hash::make('password'),
        ]);

        Student::create([
            'user_id'        => $studentUser->id,
            'internship_id'  => $internship->id,
            'nis'            => '0012345678',
            'class'          => 'XII',
            'major'          => 'RPl 1',
            'phone'          => '089876543210',
            'address'        => 'Jl. Melati No. 45, Surabaya',
        ]);
    }
}
