<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Region;
use App\Models\District;
use App\Models\Township;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request as searchRequest;

class TownshipController extends Controller
{
    public function index()
    {
        $districts=District::all();

        $townships=Township::query()
                            ->with(['district'])
                            ->when(searchRequest::input('search'), function ($query, $search) 
                                {
                                    $query->where('name', 'like', '%' . $search . '%');
                                })
                            ->when(searchRequest::input('districtsearch'), function ($query, $districtsearch) 
                                {
                                    $query->whereHas(
                                        'district', function($q) use ($districtsearch){
                                            $q->where('id', $districtsearch);
                                        }
                                    );
                                })
                            ->select('id','name','district_id')
                            ->orderBy('name','ASC')
                            ->paginate(5); 
      
        return Inertia::render('Township/TownshipIndex',[
            'townships'=>$townships,
            'districts'=>$districts,
            'filters' => searchRequest::only(['search']),
            'districtfilters' => searchRequest::only(['districtsearch']),
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
            'district_id'=>'required'
        ]);
        try {
            $township=new Township();
            $township->name=$request->name;
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
        if(Auth::user()->roles[0]->name=="Project Manager")
        {
            abort(401, 'This action is unauthorized.');
        }

        $township=Township::where('id', $id)->with(['district'])->first();
        $districts=District::all();
            if($township){
                return Inertia::render('Township/TownshipEdit',[
                    'township' => $township,
                    'districts'=>$districts
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
            'district_id'=>'required'
        ]);

     
        $Township= Township::where('id', $id)->first();
       
        if($Township){

            $Township->name=$request->name;
            $Township->district_id=$request->district_id;
            
            $Township->update();
            
            return to_route('township')->with('success','Updated successfully');
           
        }

    }

    public function destroy($id)
    {
        if(Auth::user()->roles[0]->name=="Project Manager")
        {
            abort(401, 'This action is unauthorized.');
        }

        $Township= Township::where('id', $id)->delete();
        if($Township){
            return back()->with('success','A Township was deleted successfully');
        }else{
            abort(404);
        }
      
    }
}
