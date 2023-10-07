<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AppointmentResource;
use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Spatie\GoogleCalendar\Event;

class AppointmentController extends Controller
{
    public function show()
    {
        $data = Appointment::where('created_by', Auth::id())->get();
        return response()->json([
            'statas' => true,
            'data' => AppointmentResource::collection($data)
        ]);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->toArray(), [
            'name' => 'required',
            'description' => 'required',
            'date' => 'required',
            'time' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->all(),
                'state' => false
            ]);
        }
        $appointment = Appointment::create([
            'name' => $request->name,
            'description' => $request->description,
            'date' => $request->date,
            'time' => $request->time,
            'created_by' => Auth::id(),
        ]);
        $event = new Event;
        $event->name = $request->name;
        $event->startDateTime = Carbon::parse($request->date);
        $event->endDateTime = Carbon::parse($request->date);
        $newevent = $event->save();
        $appointment->event_id = $newevent->id;
        $appointment->save();
        if ($appointment) {
            return response()->json([
                'status' => true,
                'message' => 'Appointment created successfully',
                'data' => new AppointmentResource($appointment)
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred, please try again later'
            ]);
        }
    }
    public function update(Request $request)
    {
        $validator = Validator::make($request->toArray(), [
            'name' => 'required',
            'description' => 'required',
            'date' => 'required',
            'time' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->all(),
                'state' => false
            ]);
        }
        $appointment = Appointment::find($request->id);
        if ($appointment) {
            $appointment->update([
                'name' => $request->name,
                'description' => $request->description,
                'date' => $request->date,
                'time' => $request->time,
                'created_by' => Auth::id(),
            ]);
            $event = Event::find($appointment->event_id);
            $event->name = $request->name;
            $event->startDateTime = Carbon::parse($request->date);
            $event->endDateTime = Carbon::parse($request->date);
            $newevent = $event->save();
            $appointment->event_id = $newevent->id;
            $appointment->save();
            return response()->json([
                'status' => true,
                'message' => 'Appointment Updated successfully'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Appointment Not found'
            ]);
        }
    }
    public function delete(Request $request)
    {
        $appointment = Appointment::find($request->id);
        if ($appointment) {
            $event = Event::find($appointment->event_id);
            $event->delete();
            $appointment->delete();
            return response()->json([
                'status' => true,
                'message' => 'Appointment Deleted successfully'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Appointment Not found'
            ]);
        }
    }
}
