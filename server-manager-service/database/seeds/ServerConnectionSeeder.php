<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * This class is mainly used to provide server connections for the application for testing purposes
 */ 
class ServerConnectionSeeder extends Seeder
{
    /**
     * Run the database seeds. 
     *
     * @return void
     */
    public function run()
    {
        
        DB::table('server_connections')->insert([
            'connection_name' => 'AWS Test Connection',
            'connection_method' => 'SSH',
            'hostname' =>  'this.is.fake.test.com',
            'port' => 1336,
            'username' => 'test',
            'password' => Hash::make('password'),
            'created_at' => $mytime = Carbon\Carbon::now()->toDateTimeString(),
            'user_id' => 1
        ]);
        
        DB::table('server_connections')->insert([
            'connection_name' => 'AWS Test Connection 2',
            'connection_method' => 'SSH',
            'hostname' =>  'this.is.fake.test2.com',
            'port' => 1336,
            'username' => 'test_12',
            'password' => Hash::make('password'),
            'created_at' => $mytime = Carbon\Carbon::now()->toDateTimeString(),
            'user_id' => 1
        ]);
        
        DB::table('server_connections')->insert([
            'connection_name' => 'Random Test Connection',
            'connection_method' => 'SSH',
            'hostname' =>  'this.is.fake.test3.com',
            'port' => 1336,
            'username' => 'test_123',
            'password' => Hash::make('password'),
            'created_at' => $mytime = Carbon\Carbon::now()->toDateTimeString(),
            'user_id' => 1
        ]);
        
        DB::table('server_connections')->insert([
            'connection_name' => 'Random Test Connection Other',
            'connection_method' => 'SSH',
            'hostname' =>  'this.is.fake.test4.com',
            'port' => 1336,
            'username' => 'test_123',
            'password' => Hash::make('password'),
            'created_at' => $mytime = Carbon\Carbon::now()->toDateTimeString(),
            'user_id' => 2
        ]);


    }
}
