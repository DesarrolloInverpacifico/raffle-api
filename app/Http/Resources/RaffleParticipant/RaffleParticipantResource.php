<?php

namespace App\Http\Resources\RaffleParticipant;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RaffleParticipantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            =>  $this->id,
            'type'          =>  'raffleParticipant',
            'attributes'    =>  $this->getAttributes(),
            'relationships' =>  $this->getRelationships()
        ];
    }

    /**
     * 
     */
    private function getAttributes(): array
    {
        return [
            'name'                      =>  $this->name,
            'lastName'                  =>  $this->last_name,
            'identification_number'     =>  $this->identification_number,
            'is_winner'                 =>  $this->pivot->is_winner,
            'is_active'                 =>  $this->pivot->is_active,
        ];
    }

    /**
     * 
     */
    private function getRelationships(): array
    {
        return [];
    }
}
