<?php

namespace App\Exports;

use App\Models\Region;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportRegion implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Region::all();
    }
}
