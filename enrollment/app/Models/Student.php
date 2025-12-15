<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Student extends Model
{
    protected $primaryKey = 'student_id';

    protected $fillable = [
        'student_name',
        'date_of_birth',
        'gender',
        'contact_information',
        'address',
        'guardian_name',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    /**
     * Get the enrollments for the student.
     */
    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class, 'student_id', 'student_id');
    }

    /**
     * Get the payments for the student.
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'student_id', 'student_id');
    }

    /**
     * Get the grades/performance records for the student.
     */
    public function grades(): HasMany
    {
        return $this->hasMany(Grade::class, 'student_id', 'student_id');
    }

    /**
     * Get the user account for the student.
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'student_id', 'student_id');
    }
}
