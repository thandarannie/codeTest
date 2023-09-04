<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Region;
use App\Models\District;
use App\Models\Township;
use Illuminate\Http\Request;

class TownshipController extends Controller
{
    public function index()
    {
        $townships=Township::with(['region','district'])->get();
        $regions=Region::all();
        $districts=District::all();
        return Inertia::render('Township/TownshipIndex',[
            'townships'=>$townships,
            'regions'=>$regions,
            'districts'=>$districts
        ]);  
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'region_id'=>'required',
            'district_id'=>'required'
        ]);
        try {
            $township=new Township();
            $township->name=$request->name;
            $township->region_id=$request->region_id;
            $township->district_id=$request->district_id;
            if($township->save()){
                //return to_route('district')->with('success','District was created successfully');
                return back()->with('success','Township was created successfully');
            }

        }catch (Exception $e) {
            $message = $e->getMessage();
            // return response()->json(['events'=>$request->all()]);
            return back()->withErrors('error',$message);
        }
    }

    public function edit($id)
    {
        $township=Township::where('id', $id)->first();
        $regions=Region::all();
        $districts=District::all();
            if($township){
                return Inertia::render('Township/TownshipEdit',[
                    'township' => $township,
                    'regions'=>$regions,
                    'districts'=>$districts
                ]);

            }else{
                abort(404);
            }
    }

    public function update(Request $request, $id){

        $request->validate([
            'name' => 'required',
            'region_id'=>'required',
            'district_id'=>'required'
        ]);

     
        $Township= Township::where('id', $id)->first();
       
        if($Township){

            $Township->name=$request->name;
            $Township->update();
            
            return to_route('township')->with('success','Updated successfully');
           
        }

    }

    public function destroy($id){
            $Township= Township::where('id', $id)->delete();
            if($Township){
                return back()->with('success','A Township was deleted successfully');
            }else{
                abort(404);
            }
      
    }
}
