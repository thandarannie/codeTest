<?php

namespace App\Models;

use App\Models\Patient;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Township extends Model
{
    use HasFactory;
    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function patients()
    {
        return $this->hasMany(Patient::class,'township_id','id');
    }
}
