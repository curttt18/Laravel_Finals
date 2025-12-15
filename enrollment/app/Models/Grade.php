<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Grade extends Model
{
    protected $primaryKey = 'grade_id';

    protected $fillable = [
        'student_id',
        'teacher_id',
        'academic_period',
        'cognitive_skills',
        'motor_skills',
        'social_skills',
        'emotional_dev',
        'behavior',
        'teacher_remarks',
    ];

    /**
     * Get the student for this grade.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id', 'student_id');
    }

    /**
     * Get the teacher who made this evaluation.
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class, 'teacher_id', 'teacher_id');
    }
}
