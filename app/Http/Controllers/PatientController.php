<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Patient;
use App\Models\Township;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Request as searchRequest;

class PatientController extends Controller
{
    public function index()
    {
        $patients=Patient::query()
                        ->with(['township'])
                        ->when(searchRequest::input('search'), function ($query, $search) 
                            {
                                $query->where('name', 'like', '%' . $search . '%');
                            })
                            ->when(searchRequest::input('townshipsearch'), function ($query, $townshipsearch) 
                            {
                                $query->whereHas(
                                    'township', function($q) use ($townshipsearch){
                                        $q->where('id', $townshipsearch);
                                    }
                                );
                            })
                        ->select('id','name','phone','township_id','age','address')
                        ->orderBy('name','ASC')
                        ->paginate(5); 
                     
        $townships=Township::all();
        return Inertia::render('Patient/PatientIndex',[
            'patients'=>$patients,'townships'=> $townships,
            'filters' => searchRequest::only(['search']),
            'townshipfilters' => searchRequest::only(['townshipsearch']),]);  
    }

    public function store(Request $request)
    {
        if(Auth::user()->roles[0]->name=="Project Manager")
        {
            abort(401, 'This action is unauthorized.');
        }
        $this->validate($request, [
            'name' => 'required',
            'phone' => 'required',
            'age'=>'required',
            'address' => 'required',
            'township_id'=>'required',
        ]);

        $patient = new Patient();
        $patient->name = $request->name;
        $patient->phone = $request->phone;
        $patient->age = $request->age;
        $patient->address = $request->address;
        $patient->township_id=$request->township_id;
        $patient->save();
        return back()->with('success','Added a new patient successfully');

    }

    public function edit($id)
    {
        if(Auth::user()->roles[0]->name=="Project Manager")
        {
            abort(401, 'This action is unauthorized.');
        }
        $patient=Patient::where('id', $id)->first();
        $townships=Township::all();
            if($patient){
                return Inertia::render('Patient/PatientEdit',[
                    'patient' => $patient,
                    'townships'=>$townships
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
            'name' => ['required', 'string', 'max:255'],
            'phone' => 'required',
            'address' => 'required',
            'township_id' => 'required',
            'age' => 'required',
        ]);

     
        $patient= Patient::where('id', $id)->first();
       
        if($patient){

            $patient->name=$request->name;
            $patient->phone=$request->phone;
            $patient->age=$request->age;
            $patient->address=$request->address;
            $patient->township_id=$request->township_id;
            $patient->update();
            
            return to_route('patient')->with('success','Updated successfully');
           
        }

    }

    public function destroy($id)
    {
        if(Auth::user()->roles[0]->name=="Project Manager")
        {
            abort(401, 'This action is unauthorized.');
        }
        $Patient= Patient::where('id', $id)->delete();
        if($Patient){
            return back()->with('success','Deleted successfully');
        }else{
            abort(404);
        }
  
    }

    public function exportPatients(Request $request)
    {
        if(Auth::user()->roles[0]->name=="Project Manager")
        {
            abort(401, 'This action is unauthorized.');
        }
        return Excel::download(new ExportUser, 'patients.csv');
    }
   
}
