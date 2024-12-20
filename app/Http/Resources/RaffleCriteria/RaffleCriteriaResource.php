<?php

namespace App\Http\Resources\RaffleCriteria;

use App\Http\Resources\Raffle\RaffleResource;
use App\Http\Resources\RafflePrize\RafflePrizeResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RaffleCriteriaResource extends JsonResource
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
            'type'          =>  'raffleCriteria',
            'attributes'    =>  $this->getAttributes(),
            'relationships' =>  $this->getRelationship()
        ];
    }

    /**
     * 
     */
    private function getAttributes(): array
    {
        return [
            'position'      =>  $this->position,
            'prize'         =>  $this->prize,
            'created_at'    =>  $this->created_at,
            'updated_at'    =>  $this->updated_at
        ];
    }

    /**
     * 
     */
    private function getRelationship(): array
    {
        return [
            'prizes'    =>  RafflePrizeResource::collection($this->whenLoaded('rafflePrize')),
            'raffle'    =>  RaffleResource::make($this->whenLoaded('raffle')),
        ];
    }
}
