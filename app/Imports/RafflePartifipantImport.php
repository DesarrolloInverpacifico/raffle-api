<?php

namespace App\Imports;

use App\Models\People;
use App\Models\Raffle;
use App\Models\RaffleParticipant;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class RafflePartifipantImport implements ToModel, WithHeadingRow
{
    /**
     * 
     */
    private Raffle $raffle;

    public function __construct(Raffle $raffle)
    {
        $this->raffle = $raffle;
    }
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $people = People::firstOrCreate([
            'name'                  =>  $row['nombres'],
            'last_name'             =>  $row['apellidos'],
            'identification_number' =>  $row['identificacion']
        ]);
        $this->raffle->people()->attach($people->id);

        return $people;
    }
}
