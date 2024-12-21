<?php

namespace App\Http\Resources\People;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PeopleResource extends JsonResource
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
            'type'          =>  'people',
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
            'name'                  =>  $this->name,
            'lastName'              =>  $this->last_name,
            'identification_number' =>  $this->identification_number,
            'created_at'            =>  $this->created_at,
            'updated_at'            =>  $this->updated_at
        ];
    }

    /**
     * 
     */
    private function getRelationship(): array
    {
        return [];
    }
}
