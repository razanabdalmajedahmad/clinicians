<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::firstOrCreate(['email' => 'Doctor@gmial.com'],
         [
            'name' => 'Doctor',
            'email'=>'Doctor@gmial.com',
            'password'=>Hash::make('123456789'),
            'role_id'=>Role::where('name','Doctor')->first()->id,
        ]);
    }
}
