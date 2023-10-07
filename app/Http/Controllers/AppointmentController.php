<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Auth;
use Spatie\GoogleCalendar\Event;

class AppointmentController extends Controller
{
    public function index(){
        return view('Dashbord.appointment.index');
    }
    public function show(Request $request)
    {
        $data = Appointment::where('created_by',Auth::id())->select('*');
        if(!empty($request->get('query'))){
            $serch=$request->get('query');
            $data=$data->where('name', 'LIKE', "%$serch%") ;
        }
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $actionBtn ='<a href="'.route('appointment_update',$row->id).'" class="btn btn-success">Edit</a>
                <button  class="btn btn-danger delete">Delete</button>';
                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    public function createnew(){
        return view('Dashbord.appointment.create');
    }
    public function store(Request $request){
        $request->validate([
            'name'=>'required',
            'description'=>'required',
            'date'=>'required',
            'time'=>'required',
        ]);
        $items = $request->except('_token');
        $items['created_by']=Auth::id();

        $appointment=Appointment::create($items);
        if( $appointment){
            $event = new Event;
            $event->name = $request->name;
            $event->startDateTime = Carbon::parse($request->date);
            $event->endDateTime =Carbon::parse($request->date) ;
            $newevent=$event->save();
            $appointment->event_id=$newevent->id;
            $appointment->save();
            session()->flash('success', 'Appointment created successfully');
            return response()->json([
                'status'=>true,
                'message'=>'Appointment created successfully'
            ]);
        }else{
            return response()->json([
                'status'=>false,
                'message'=>'An error occurred, please try again later'
            ]);
        }
    }
    public function delete(Request $request){
        $appointment=Appointment::find($request->id);
        if($appointment){

            $event = Event::find($appointment->event_id);
            $event->delete();
            $appointment->delete();
            return response()->json([
                'status'=>true,
                'message'=>'Appointment Deleted successfully'
            ]);
        }else{
            return response()->json([
                'status'=>false,
                'message'=>'Appointment Not found'
            ]);
        }
    }
    public function edit($id){
        $appointment=Appointment::find($id);
        if($appointment){
            return view('Dashbord.appointment.edit',compact('appointment'));
        }else{
            return redirect()->route('appointment_list')->with('error','Appointment not found');
        }
    }
    public function update(Request $request){
        $request->validate([
            'name'=>'required',
            'description'=>'required',
            'date'=>'required',
            'time'=>'required',
        ]);
        $appointment=Appointment::find($request->id);
        if($appointment){
            $items = $request->except(['_token','id']);
            $items['created_by']=Auth::id();
            $appointment->update($items);
            $event = Event::find($appointment->event_id);
            $event->name = $request->name;
            $event->startDateTime = Carbon::parse($request->date);
            $event->endDateTime =Carbon::parse($request->date) ;
            $newevent=$event->save();
            $appointment->event_id=$newevent->id;
            $appointment->save();
            session()->flash('success', 'Appointment Updated successfully');
            return response()->json([
                'status'=>true,
                'message'=>'Appointment Updated successfully'
            ]);
        }else{
            return response()->json([
                'status'=>false,
                'message'=>'Appointment Not found'
            ]);
        }
    }
}
