<?php

namespace App\Exports;

use App\Models\People;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PeopleExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return People::all();
    }

    public function headings(): array
    {
        return [
            'id',
            'nombre',
            'apellidos',
            'cedula',
        ];
    }
}
