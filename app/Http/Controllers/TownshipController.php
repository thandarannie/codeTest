<?php

namespace App\Http\Controllers;

use App\Models\Township;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TownshipController extends Controller
{
    public function index()
    {
        $townships=Township::all();
        return Inertia::render('Township/TownshipIndex',[
            'townships'=>$townships]);  
    }
}
