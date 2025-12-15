<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $primaryKey = 'payment_id';

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'payment_id';
    }

    protected $fillable = [
        'student_id',
        'fee_id',
        'payment_date',
        'payment_amount',
        'payment_type',
        'remarks',
    ];

    protected $casts = [
        'payment_date' => 'date',
        'payment_amount' => 'decimal:2',
    ];

    /**
     * Get the student for this payment.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id', 'student_id');
    }

    /**
     * Get the fee type for this payment.
     */
    public function fee(): BelongsTo
    {
        return $this->belongsTo(Fee::class, 'fee_id', 'fee_id');
    }
}
