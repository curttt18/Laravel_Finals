<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Fee extends Model
{
    protected $primaryKey = 'fee_id';

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'fee_id';
    }

    protected $fillable = [
        'fee_name',
        'amount',
        'description',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    /**
     * Get the payments for this fee type.
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'fee_id', 'fee_id');
    }
}
