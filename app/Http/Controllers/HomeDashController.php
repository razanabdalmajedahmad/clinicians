<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeDashController extends Controller
{
    public function home(){
        return view('Dashbord.Home');
    }
    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
        return redirect()->route('get_login');
    }
    public function Calender(Request $request){
        $celendar = Appointment::get();
        $events=[];
        foreach($celendar as $key){
            $events[]=[
                'title' => $key->name,
                'start' => $key->date,
                'end' => $key->date,
                'id' => $key->id,
                'des'=>$key->description,
                'time'=>$key->time,
                'color' => '#0ad2a0'
            ];
        }

        return view('Calender',compact('events'));
    }
}
