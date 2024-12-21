<?php

namespace App\Imports;

use App\Models\People;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PeopleImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $person = People::where('identification_number', '=', $row['identificacion'])->first();

        if (!is_null($person)) {
            return;
        }

        return People::create([
            'name'                  =>  $row['nombres'],
            'last_name'             =>  $row['apellidos'],
            'identification_number' =>  $row['identificacion'],
        ]);;
    }
}
