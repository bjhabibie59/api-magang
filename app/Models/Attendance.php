<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    use HasUuids;

    protected $fillable = [
        'student_id', 'date', 'check_in',
        'check_out', 'latitude', 'longitude',
    ];

    protected function casts(): array
    {
        return [
            'date'      => 'date',
            'check_in'  => 'datetime:H:i:s',
            'check_out' => 'datetime:H:i:s',
        ];
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}
