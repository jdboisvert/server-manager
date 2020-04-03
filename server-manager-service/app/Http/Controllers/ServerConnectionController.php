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
            
            if(!$user){
                //Should never reach this with middleware
                error_log('User got to method through middleware');
                return response()->json(['message' => 'Not authorized.'], 401);
            }
            
            $servers = ServerConnection::where('user_id', $user->id)->get();
            
            return response()->json(['servers' => $servers], 200);
        } catch (\Exception $e) {
            error_log($e->getMessage());
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
            
            if(!$user){
                //Should never reach this with middleware
                error_log('User got to method through middleware');
                return response()->json(['message' => 'Not authorized.'], 401);
            }

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
        
        try {
            
            $server = ServerConnection::find($id);
            
            if(!$server){
                return response()->json(['message' => 'Server not found'], 404);
            } 
            
            $user = $request->user();
            
            if(!$user){
                //Should never reach this with middleware
                error_log('User got to method through middleware');
                return response()->json(['message' => 'Not authorized.'], 401);
            }
            
            if($user->id != $server->user_id){
                return response()->json(['message' => 'Not authorized to view server'], 403);
            }
            
            return response()->json(['server' => $server], 200);
            
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return response()->json(['message' => 'Problem retrieving server'], 500);
        }
        
    }
    
    /**
     * Update a server connection
     *
     * @param  Request  $request
     * @param $id holding the id of the server in question
     * @return Response
     */
    public function updateServerConnection(Request $request, $id){
        
        $this->validate($request, [
            'connection_name' => 'required_without_all:connection_method,hostname,port,username,password|string|max:255',
            'connection_method' => 'required_without_all:connection_name,hostname,port,username,password|string|max:255',
            'hostname' => 'required_without_all:connection_name,connection_name,port,username,password|string|max:255',
            'port' => 'required_without_all:connection_name,connection_name,hostname,username,password|integer|min:0|max:65535',
            'username' => 'required_without_all:connection_name,connection_name,hostname,port,password|string|max:255',
            'password' => 'required_without_all:connection_name,connection_name,hostname,port,username|string|max:255'
        ]);

        try {

            $user = $request->user();
            
            if(!$user){
                //Should never reach this with middleware
                error_log('User got to method through middleware');
                return response()->json(['message' => 'Not authorized.'], 401);
            }

            $server = ServerConnection::find($id);
            
            if(!$server){
                return response()->json(['message' => 'Server not found'], 404);
            } 
            
            if($user->id != $server->user_id){
                return response()->json(['message' => 'Not authorized to update server'], 403);
            }
            
            if ($request->has('connection_name')){
                $server->connection_name = $request->input('connection_name');
            } 
            if ($request->has('connection_method')){
                $server->connection_name = $request->input('connection_method');
            } 
            if ($request->has('hostname')){
                $server->connection_name = $request->input('hostname');
            } 
            if ($request->has('port')){
                $server->connection_name = $request->input('port');
            }
            if ($request->has('username')){
                $server->connection_name = $request->input('username');
            }
            if ($request->has('password')){
                $plainPassword = $request->input('password');
                $server->password = Hash::make($plainPassword);
            }

            $server->save();

            return response()->json(['server' => $server, 'message' => 'Updated successfully'], 200);

        } catch (\Exception $e) {
            error_log($e->getMessage());
            return response()->json(['message' => 'Server update failed!'], 409);
        }
    }
    
    /**
     * Delete a server connection
     *
     * @param  Request  $request
     * @param  $id holding the id of the server in question
     * @return Response
     */
    public function deleteServerConnection(Request $request, $id){
        
        try {
            
            $server = ServerConnection::find($id);
            
            if(!$server){
                return response()->json(['message' => 'Server not found'], 404);
            } 
            
            $user = $request->user();
            
            if(!$user){
                //Should never reach this with middleware
                error_log('User got to method through middleware');
                return response()->json(['message' => 'Not authorized.'], 401);
            }
            
            if($user->id != $server->user_id){
                return response()->json(['message' => 'Not authorized to delete server'], 403);
            }
            
            $server->delete();
            
            return response()->json(['message' => 'Server deleted successfully'], 200);
            
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return response()->json(['message' => 'Problem deleting server'], 500);
        }
        
    }

}