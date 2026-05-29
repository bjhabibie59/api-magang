<?php

namespace App\Models;

use App\Helpers\Enum\RoleEnum;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasUuids;

    protected $fillable = ['name', 'username', 'email', 'password'];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    public function admin(): HasOne
    {
        return $this->hasOne(Admin::class);
    }

    public function teacher(): HasOne
    {
        return $this->hasOne(Teacher::class);
    }

    public function student(): HasOne
    {
        return $this->hasOne(Student::class);
    }

    /**
     * Dipanggil setelah loadMissing(['admin', 'teacher', 'student'])
     */
    public function getRole(): string
    {
        if ($this->relationLoaded('admin') && $this->admin) {
            return $this->admin->level;
        }

        if ($this->relationLoaded('teacher') && $this->teacher) {
            return RoleEnum::TEACHER->value;
        }

        if ($this->relationLoaded('student') && $this->student) {
            return RoleEnum::STUDENT->value;
        }

        return 'unknown';
    }
}
