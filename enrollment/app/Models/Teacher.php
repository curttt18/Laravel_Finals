<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Teacher extends Model
{
    protected $primaryKey = 'teacher_id';

    protected $fillable = [
        'teacher_name',
        'contact_information',
    ];

    /**
     * Get the grades/evaluations made by this teacher.
     */
    public function grades(): HasMany
    {
        return $this->hasMany(Grade::class, 'teacher_id', 'teacher_id');
    }
}
