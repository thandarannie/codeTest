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
                //return to_route('district')->with('success','District was created successfully');
                return back()->with('success','District was created successfully');
            }

        }catch (Exception $e) {
            $message = $e->getMessage();
            // return response()->json(['events'=>$request->all()]);
            return back()->withErrors('error',$message);
        }
    }

    public function edit($id)
    {
        $district=District::where('id', $id)->first();
            if($district){
                return Inertia::render('District/DistrictEdit',[
                    'district' => $district
                ]);

            }else{
                abort(404);
            }
    }

    public function update(Request $request, $id){

        $request->validate([
            'name' => 'required',
        ]);

     
        $district= District::where('id', $id)->first();
       
        if($district){

            $district->name=$request->name;
            $district->update();
            
            return to_route('district')->with('success','Updated successfully');
           
        }

    }

    public function destroy($id){
            $district= District::where('id', $id)->delete();
            if($district){
                return back()->with('success','A district was deleted successfully');
            }else{
                abort(404);
            }
      
    }
}
