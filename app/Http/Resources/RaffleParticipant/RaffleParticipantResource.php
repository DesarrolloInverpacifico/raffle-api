<?php

namespace App\Http\Resources\RaffleParticipant;

use App\Http\Resources\Raffle\RaffleResource;
use App\Http\Resources\RafflePrize\RafflePrizeResource;
use App\Models\RafflePrize;
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
            'name'                  =>  $this->name,
            'email'                 =>  $this->email,
            'identification_number' =>  $this->identification_number,
            'is_winner'             =>  $this->is_winner,
            'won_at'                =>  $this->won_at,
        ];
    }

    /**
     * 
     */
    private function getRelationships(): array
    {
        return [
            'raffle'    =>  RaffleResource::make($this->whenLoaded('raffle')),
            'prizes'    =>  RafflePrizeResource::collection($this->whenLoaded('rafflePrize')),
        ];
    }
}
