<?php

namespace App\Models;

use App\Models\Township;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Patient extends Model
{
    use HasFactory;
    
    public function township()
    {
        return $this->belongsTo(Township::class);
    }
}
