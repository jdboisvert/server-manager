<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  App\User;
use App\ServerConnection; 
use Illuminate\Support\Facades\Hash;

/**
 * Used to handle logic associated with server connections. 
 */ 
class ServerConnectionController extends Controller
{
    
    /**
     * Get all the connections belonging to a user
     *
     * @param  Request  $request
     * @return Response
     */
    public function getAllServerConnections(Request $request){
        
        try {
            $user = $request->user();
            $servers = ServerConnection::where('user_id', $user->id)->get();
            
            return response()->json(['servers' => $servers], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Problem retrieving servers'], 500);
        }

    }
    
    /**
     * Create a server connection
     *
     * @param  Request  $request
     * @return Response
     */
    public function createServerConnection(Request $request){
        
        $this->validate($request, [
            'connection_name' => 'required|string|max:255',
            'connection_method' => 'required|string|max:255',
            'hostname' => 'required|string|max:255',
            'port' => 'required|integer|min:0|max:65535',
            'username' => 'required|string|max:255',
            'password' => 'required|string|max:255'
        ]);

        try {

            $user = $request->user();

            $server = new ServerConnection;
            $server->connection_name = $request->input('connection_name');
            $server->connection_method = $request->input('connection_method');
            $server->hostname = $request->input('hostname');
            $server->port = $request->input('port');
            $server->username = $request->input('username');
            $plainPassword = $request->input('password');
            $server->password = Hash::make($plainPassword);
            $server->user_id = $user->id; 

            $server->save();

            return response()->json(['server' => $server, 'message' => 'Created successfully'], 201);

        } catch (\Exception $e) {
            //return error message
            error_log($e->getMessage());
            return response()->json(['message' => 'Server registration failed!'], 409);
        }
        
    }
    
    /**
     * Read a single server connection
     *
     * @param  Request  $request
     * @param $id holding the id of the server in question
     * @return Response
     */
    public function readServerConnection(Request $request, $id){
        
        $server = ServerConnection::findOrFail($id);
        
        try {
            $server = ServerConnection::findOrFail($id);
            return response()->json(['server' => $server], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Problem retrieving items'], 500);
        }
        
    }
    
    /**
     * Update a server connection
     *
     * @param  Request  $request
     * @return Response
     */
    public function updateServerConnection(Request $request){
        //TODO
    }
    
    /**
     * Delete a server connection
     *
     * @param  Request  $request
     * @return Response
     */
    public function deleteServerConnection(Request $request){
        //TODO
    }


}