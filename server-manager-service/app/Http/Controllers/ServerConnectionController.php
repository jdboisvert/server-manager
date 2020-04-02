<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  App\User;

class ServerConnectionController extends Controller
{
    
    public function test(Request $request){
        
        $user = $request->user();
        
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
     * @param $id holding the id of the server in question
     * @return Response
     */
    public function readServerConnection(Request $request, $id){
        
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