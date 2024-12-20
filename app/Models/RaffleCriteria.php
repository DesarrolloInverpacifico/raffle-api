<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RaffleCriteria extends Model
{
    use HasFactory;

    protected $fillable = [
        'raffle_id',
        'prize',
        'position'
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
    public function rafflePrize(): BelongsTo
    {
        return $this->belongsTo(RafflePrize::class, 'raffle_prize_id');
    }
}
