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
            'Role',
            'Date'
        ];
    }
    public function collection()
    {
        $users=  User::join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                    ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
                    ->select('users.id','users.name as username','users.email','roles.name','users.created_at')
                    ->get();
        return $users;
    }
}
