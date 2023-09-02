<?php

namespace App\Http\Controllers;

use App\Models\District;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Exception;

class DistrictController extends Controller
{
     public function index()
    {
        $districts=District::all();
        return Inertia::render('District/DistrictIndex',[
            'districts'=>$districts]);  
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        try {
            $district=new District();
            $district->name=$request->name;
            if($district->save()){
                return back()->with('success','District was created successfully');
            }

        }catch (Exception $e) {
            $message = $e->getMessage();
            // return response()->json(['events'=>$request->all()]);
            return back()->withErrors('error',$message);
        }
    }
}
