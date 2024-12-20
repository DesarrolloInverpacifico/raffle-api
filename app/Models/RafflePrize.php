<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RafflePrize extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'raffle_id'
    ];

    /**
     * 
     */
    public function raffle(): BelongsTo
    {
        return $this->belongsTo(Raffle::class, 'raffle_id');
    }

    /**
     * 
     */
    public function criteria(): HasMany
    {
        return $this->hasMany(RaffleCriteria::class, 'raffle_prize_id');
    }
}
