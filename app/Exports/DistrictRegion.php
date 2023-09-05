<?php

namespace App\Exports;

use App\Models\District;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class DistrictRegion implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings():array{
        return [
            'id',
            'Region',
            'Name',
        ];
    }
    public function collection()
    {
        return User::select('id','region_id','name')->get();
    }
}
