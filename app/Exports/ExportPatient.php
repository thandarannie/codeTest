<?php

namespace App\Exports;

use App\Models\Patient;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportPatient implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection,WithHeadings
    */
    public function headings():array{
        return [
            'id',
            'Name','Phone','Age','Address'
        ];
    }
    public function collection()
    {
        return User::select('id','name','phone','age','address')->get();
    }
}
