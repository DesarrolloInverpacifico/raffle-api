<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class People extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'last_name',
        'identification_number'
    ];

    /**
     * 
     */
    public function raffles(): BelongsToMany
    {
        return $this->belongsToMany(Raffle::class, 'people_raffles', 'people_id', 'raffle_id')
            ->withPivot(['is_winner', 'is_active']);
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
            $query->where('name', 'like', "%{$s}%")
                ->orWhere('last_name', 'like', "%{$s}%")
                ->orWhere('identification_number', 'like', "%{$s}%");
        }
    }
}
