<?php

namespace App\Http\Controllers;

use App\Models\Role;
use DataTables;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(){
        return view('Dashbord.User.index');
    }
    public function show(Request $request)
    {
        $data = User::whereNotIn('id',[Auth::id()])->select('*');

        if(!empty($request->get('query'))){
            $serch=$request->get('query');
            $data=$data->where('name', 'LIKE', "%$serch%") ;
        }
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $actionBtn ='<a href="'.route('user_update',$row->id).'" class="btn btn-success">Edit</a>
                <button  class="btn btn-danger delete">Delete</button>';
                return $actionBtn;
            })
            ->addColumn('role', function($row){
                $role=Role::find($row->role_id);
                return ($role) ? $role->name : '';
            })
            ->rawColumns(['action','role'])
            ->make(true);
    }
    public function createnew(){
        $roles=Role::get();
        return view('Dashbord.User.create',compact('roles'));
    }
    public function store(Request $request){
        $request->validate([
            'name'=>'required',
            'email'=>'required|email|unique:users,email',
            'password'=>'required',
            'renewpassword'=>'required|same:password',
            'role'=>'required'
        ],[

            'renewpassword.required'=>'The Re-enter Password field is required.',
            'renewpassword.same'=>'The Re-enter Password and password must match.'
        ]);
        $user=User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'role_id'=>$request->role
        ]);
        if( $user){
            session()->flash('success', 'User created successfully');
            return response()->json([
                'status'=>true,
                'message'=>'User created successfully'
            ]);
        }else{
            return response()->json([
                'status'=>false,
                'message'=>'An error occurred, please try again later'
            ]);
        }

    }
    public function delete(Request $request){
        $user=User::find($request->id);
        if($user){
            $user->delete();
            return response()->json([
                'status'=>true,
                'message'=>'User Deleted successfully'
            ]);
        }else{
            return response()->json([
                'status'=>false,
                'message'=>'User Not found'
            ]);
        }
    }
    public function edit($id){
        $user=User::find($id);
        if($user){
            $roles=Role::get();
            return view('Dashbord.User.edit',compact('user','roles'));
        }else{
            return redirect()->route('user_list')->with('error','user not found');
        }
    }
    public function update(Request $request){
        $request->validate([
            'name'=>'required',
            'email'=>'required|email|unique:users,email,'. $request->id,
            'role'=>'required'
        ]);
        $user=User::find($request->id);
        if($user){
            $user->update([
                'name'=>$request->name,
                'email'=>$request->email,
                'role_id'=>$request->role
            ]);
            session()->flash('success', 'User Updated successfully');
            return response()->json([
                'status'=>true,
                'message'=>'User Updated successfully'
            ]);
        }else{
            return response()->json([
                'status'=>false,
                'message'=>'User Not found'
            ]);
        }
    }
}
