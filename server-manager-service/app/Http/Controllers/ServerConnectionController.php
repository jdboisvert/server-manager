<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  App\User;

class ServerConnectionController extends Controller
{
    
    public function test(Request $request){
        
        //Is this user there? 
        
        //$user = Auth::user();

        $user = $request->user();
        
        //$user = $request->auth; 
        
        return response()->json(['user' => $user, 'message' => 'IT WORKED'], 201);
        
    }
    
    /**
     * Get all the connections belonging to a user
     *
     * @param  Request  $request
     * @return Response
     */
    public function getAllServerConnections(Request $request){


    }
    
    /**
     * Create a server connection
     *
     * @param  Request  $request
     * @return Response
     */
    public function createServerConnection(Request $request){
        
    }
    
    /**
     * Read a single server connection
     *
     * @param  Request  $request
     * @return Response
     */
    public function readServerConnection(Request $request){
        
    }
    
    /**
     * Update a server connection
     *
     * @param  Request  $request
     * @return Response
     */
    public function updateServerConnection(Request $request){
        
    }
    
    /**
     * Delete a server connection
     *
     * @param  Request  $request
     * @return Response
     */
    public function deleteServerConnection(Request $request){
        
    }


}