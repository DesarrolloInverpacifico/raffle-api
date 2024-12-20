<?php

namespace App\Http\Resources\RafflePrize;

use App\Http\Resources\Raffle\RaffleResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RafflePrizeResource extends JsonResource
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
            'type'          =>  'rafflePrize',
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
            'name'          =>  $this->name,
            'description'   =>  $this->description,
        ];
    }

    /**
     * 
     */
    private function getRelationships(): array
    {
        return [
            'raffle'    =>  RaffleResource::make($this->whenLoaded('raffle'))
        ];
    }
}
