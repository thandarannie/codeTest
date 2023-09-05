<?php

namespace App\Http\Controllers;

use Exception;
use Inertia\Inertia;
use App\Models\Region;
use App\Models\District;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request as searchRequest;

class DistrictController extends Controller
{
     public function index()
    {
        $regions=Region::all();

        $districts=District::query()
                    ->with(['region'])
                    ->when(searchRequest::input('search'), function ($query, $search) 
                        {
                            $query->where('name', 'like', '%' . $search . '%');
                        })
                
                    ->select('id','name','region_id')
                    ->orderBy('name','ASC')
                    ->paginate(5);   

        return Inertia::render('District/DistrictIndex',[
            'districts'=>$districts,
            'regions'=>$regions,
            'filters' => searchRequest::only(['search']),
        ]);  
    }

    public function store(Request $request)
    {
        if(Auth::user()->roles[0]->name=="Project Manager")
        {
            abort(401, 'This action is unauthorized.');
        }

        $request->validate([
            'name' => 'required',
            'region_id'=>'required'
        ]);
        try {
            $district=new District();
            $district->name=$request->name;
            $district->region_id=$request->region_id;
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
        if(Auth::user()->roles[0]->name=="Project Manager")
        {
            abort(401, 'This action is unauthorized.');
        }
        $district=District::where('id', $id)->with(['region'])->first();
        $regions=Region::all();
            if($district){
                return Inertia::render('District/DistrictEdit',[
                    'district' => $district,
                    'regions' => $regions
                ]);

            }else{
                abort(404);
            }
    }

    public function update(Request $request, $id)
    {
        if(Auth::user()->roles[0]->name=="Project Manager")
        {
            abort(401, 'This action is unauthorized.');
        }
        $request->validate([
            'name' => 'required',
            'region_id'=>'required'
        ]);

     
        $district= District::where('id', $id)->with(['region'])->first();
       
        if($district){

            $district->name=$request->name;
            $district->region_id=$request->region_id;
            $district->update();
            
            return to_route('district')->with('success','Updated successfully');
           
        }

    }

    public function destroy($id)
    {
        if(Auth::user()->roles[0]->name=="Project Manager")
        {
            abort(401, 'This action is unauthorized.');
        }
            $district= District::where('id', $id)->delete();
            if($district){
                return back()->with('success','A district was deleted successfully');
            }else{
                abort(404);
            }
      
    }
}
