<?php

namespace App\Http\Resources\Raffle;

use App\Http\Resources\RaffleCriteria\RaffleCriteriaResource;
use App\Http\Resources\RaffleParticipant\RaffleParticipantResource;
use App\Http\Resources\RafflePrize\RafflePrizeResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RaffleResource extends JsonResource
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
            'type'          =>  'raffle',
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
            'name'          =>  $this->name,
            'description'   =>  $this->description,
            'date'          =>  $this->date,
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
            'prizes'        => RafflePrizeResource::collection($this->whenLoaded('rafflePrizes')),
            'criterias'     => RaffleCriteriaResource::collection($this->whenLoaded('raffleCriterias')),
            'participants'  => RaffleParticipantResource::collection($this->whenLoaded('raffleParticipants')),
        ];
    }
}
