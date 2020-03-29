<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * This class is mainly used to provide users for the application for testing purposes
 */ 
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Jeffrey',
            'email' => 'jeff@test.com',
            'password' =>  Hash::make('password'),
            'created_at' => $mytime = Carbon\Carbon::now()->toDateTimeString(),
        ]);
    }
}
