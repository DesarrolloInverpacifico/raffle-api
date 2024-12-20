<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Raffle extends Model
{

    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'date'
    ];

    /**
     * 
     */
    public function raffleCriterias(): HasMany
    {
        return $this->hasMany(RaffleCriteria::class, 'raffle_id');
    }

    /**
     * 
     */
    public function raffleParticipants(): HasMany
    {
        return $this->hasMany(RaffleParticipant::class, 'raffle_id');
    }

    /**
     * Scope a query to search name company 
     * 
     * @param Illuminate\Database\Eloquent\Builder $query
     * @param string $s
     * @return void
     */
    public function scopeSearch(Builder $query, string $s = null): void
    {
        if (!is_null($s)) {
            $query->where('name', 'like', "%{$s}%");
        }
    }
}
