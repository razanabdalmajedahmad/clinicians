<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function Role(){
        return $this->belongsTo(Role::class,'role_id');
    }
    public function getDoctorid(){
        $role_id=Role::where('name','Doctor')->first()->id;
        return $role_id;
    }
    public function isDoctor(){
        if(Auth::user()->role_id == $this->getDoctorid()){
            return true;
        }else{
            return false;
        }
    }

    public function getSecretaryid(){
        $role_id=Role::where('name','Secretary')->first()->id;
        return $role_id;
    }
    public function isSecretary(){
        if(Auth::user()->role_id == $this-> getSecretaryid()){
            return true;
        }else{
            return false;
        }
    }
}
