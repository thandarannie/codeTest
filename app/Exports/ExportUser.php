<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportUser implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    
    public function headings():array{
        return [
            'id',
            'Name',
            'Email',
            'Role'
        ];
    }
    public function collection()
    {
        return User::select('id','name','email')->get();
    }
}
