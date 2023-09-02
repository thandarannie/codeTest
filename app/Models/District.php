<?php

namespace App\Models;

use App\Models\Township;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class District extends Model
{
    use HasFactory;
    
    public function townships()
    {
        return $this->hasMany(Township::class,'district_id','id');
    }
}
