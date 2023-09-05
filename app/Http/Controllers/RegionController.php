<?php

namespace App\Http\Controllers;

use App\Models\Region;
use Illuminate\Http\Request;
use Inertia\Inertia;
class RegionController extends Controller
{
    public function index()
    {
        $regions=Region::all();
        return Inertia::render('Region/RegionIndex',[
            'regions'=>$regions]); 
    }

    public function store(Request $request)
    {
        if(Auth::user()->roles[0]->name=="Project Manager")
        {
            abort(401, 'This action is unauthorized.');
        }

        $request->validate([
            'name' => 'required',
        ]);
        try {
            $region=new Region();
            $region->name=$request->name;
            if($region->save()){
                return back()->with('success','State/Region was created successfully');
            }

        }catch (Exception $e) {
            $message = $e->getMessage();
            return back()->withErrors('error',$message);
        }
    }

    public function edit($id)
    {
        if(Auth::user()->roles[0]->name=="Project Manager")
        {
            abort(401, 'This action is unauthorized.');
        }

        $region=Region::where('id', $id)->first();
            if($region){
                return Inertia::render('Region/RegionEdit',[
                    'region' => $region
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
        ]);

     
        $region= Region::where('id', $id)->first();
       
        if($region){

            $region->name=$request->name;
            $region->update();
            
            return to_route('region')->with('success','Updated successfully');
           
        }

    }

    public function destroy($id)
    {
        if(Auth::user()->roles[0]->name=="Project Manager")
        {
            abort(401, 'This action is unauthorized.');
        }
            $region= Region::where('id', $id)->delete();
            if($region){
                return back()->with('success','A region was deleted successfully');
            }else{
                abort(404);
            }
      
    }
}
