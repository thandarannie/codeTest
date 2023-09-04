<?php

namespace App\Exports;

use App\Models\Township;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportTownship implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Township::all();
    }
}
