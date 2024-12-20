<?php

namespace App\Imports;

use App\Models\RaffleParticipant;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class RafflePartifipantImport implements ToModel, WithHeadingRow
{
    /**
     * 
     */
    private $raffleId;

    public function __construct($raffleId)
    {
        $this->raffleId = $raffleId;
    }
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new RaffleParticipant([
            'raffle_id'             =>  $this->raffleId,
            'name'                  =>  $row['participante'],
            'identification_number' =>  $row['identificacion'],
        ]);
    }
}
