<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use App\User;

/**
 * Used to test API calls for server connections when logged in as a valid user. 
 */ 
class ServerConnectionAPITest extends TestCase
{
    
    private $emailOfTestUser = 'jeff@test.com';
    private $passwordOfTestUser = 'password';
    
    //Do not effect current database
    use DatabaseTransactions;
    
    /**
     * Used to login into the API to perform test
     */ 
    public function login(){
        
        $data= ['email'=>$this->emailOfTestUser, 'password'=>$this->passwordOfTestUser];
        $user = User::where('email', $this->emailOfTestUser)->first();
        $this->actingAs($user, 'api')->json('POST', '/api/login', $data);
        
        $content = json_decode($this->response->getContent());
        
        return $content->token;
        
     }
    
    /**
     * A test to validate the correct 
     * HTTP 200 is returned when getting list of servers
     * and list is in the correct format.
     * @return void
     */
    public function testGetList(){
        
        //Used to to login to get token
        $token = $this->login();
        
        $user = User::where('email', $this->emailOfTestUser)->first();
        $response = $this->actingAs($user, 'api')->json('GET', "/api/list?token=$token");
        
        $response->seeStatusCode(200);
        $response->seeJsonStructure([
            'servers' => ['*' =>
                [
                    'id',
                    'created_at',
                    'updated_at',
                    'connection_name',
                    'connection_method',
                    'hostname',
                    'port',
                    'username',
                    'user_id'
                ]
            ]
        ]);

    }
    
    /**
     * A test to validate the correct 
     * HTTP 401 is returned when getting list of servers when not logged in
     * @return void
     */
    public function testGetListUnauthorized(){
        
        $user = User::where('email', $this->emailOfTestUser)->first();
        $response = $this->actingAs($user, 'api')->json('GET', "/api/list");
        
        $response->seeStatusCode(401);

    }
    
    /**
     * A test to validate the correct 
     * HTTP 201 is returned when creating a server
     * and response is in the correct format
     * @return void
     */
    public function testCreateServer(){
        
        //Used to to login to get token
        $token = $this->login();
        
        $user = User::where('email', $this->emailOfTestUser)->first();
        $data = [
            "connection_name"=> "Test 1", 
            "connection_method"=> "SSH", 
            "hostname"=> "amazon.ec2.something.com", 
            "port"=> 3556, 
            "username"=> "username", 
            "password"=> "password"
            ];
        $response = $this->actingAs($user, 'api')->json('POST', "/api/create?token=$token", $data);
        
        $response->seeStatusCode(201);
        $response->seeJsonStructure([
            'server' => 
                [
                    'id',
                    'created_at',
                    'updated_at',
                    'connection_name',
                    'connection_method',
                    'hostname',
                    'port',
                    'username',
                    'user_id'
                ]
        ]);

    }
    
        
    /**
     * A test to validate the correct 
     * HTTP 401 is returned when creating a server when unauthorized
     * @return void
     */
    public function testCreateServerUnauthorized(){
        
        $user = User::where('email', $this->emailOfTestUser)->first();
        $data = [
            "connection_name"=> "Test 1", 
            "connection_method"=> "SSH", 
            "hostname"=> "amazon.ec2.something.com", 
            "port"=> 3556, 
            "username"=> "username", 
            "password"=> "password"
            ];
        $response = $this->actingAs($user, 'api')->json('POST', "/api/create", $data);
        
        $response->seeStatusCode(401);

    }
    
    /**
     * A test to validate the correct 
     * HTTP 422 is returned when creating a server and missing a parameter
     * @return void
     */
    public function testCreateServerMissingParameter(){
        
        //Used to to login to get token
        $token = $this->login();
        
        $user = User::where('email', $this->emailOfTestUser)->first();
        $data = [
            "connection_name"=> "Test 1", 
            "connection_method"=> "SSH", 
            "port"=> 3556, 
            "username"=> "username", 
            "password"=> "password"
            ];
        $response = $this->actingAs($user, 'api')->json('POST', "/api/create?token=$token", $data);
        
        $response->seeStatusCode(422);

    }
    
    /**
     * A test to validate the correct 
     * HTTP 200 is returned when viewing a server
     * and response is in the correct format
     * @return void
     */
    public function testServerDetails(){
        
        //Used to to login to get token
        $token = $this->login();
        
        $user = User::where('email', $this->emailOfTestUser)->first();
        $response = $this->actingAs($user, 'api')->json('GET', "/api/server/details/1?token=$token");
        
        $response->seeStatusCode(200);
        $response->seeJsonStructure([
            'server' => 
                [
                    'id',
                    'created_at',
                    'updated_at',
                    'connection_name',
                    'connection_method',
                    'hostname',
                    'port',
                    'username',
                    'user_id'
                ]
        ]);

    }
    
    /**
     * A test to validate the correct 
     * HTTP 404 is returned when viewing a server
     * that does not exist
     * @return void
     */
    public function testServerDetailsNoServer(){
        
        //Used to to login to get token
        $token = $this->login();
        
        $user = User::where('email', $this->emailOfTestUser)->first();
        $response = $this->actingAs($user, 'api')->json('GET', "/api/server/details/166?token=$token");
        
        $response->seeStatusCode(404);

    }
    
    /**
     * A test to validate the correct 
     * HTTP 401 is returned when viewing a server when unauthorized
     * @return void
     */
    public function testServerDetailsUnauthorized(){
        
        $user = User::where('email', $this->emailOfTestUser)->first();
        $response = $this->actingAs($user, 'api')->json('GET', "/api/server/details/1");
        
        $response->seeStatusCode(401);

    }
    
    /**
     * A test to validate the correct 
     * HTTP 403 is returned when viewing a server
     * that does not belong to a user (does not have access)
     * @return void
     */
    public function testServerDetailsNotBelongingToUser(){
        
        //Used to to login to get token
        $token = $this->login();
        
        $user = User::where('email', $this->emailOfTestUser)->first();
        $response = $this->actingAs($user, 'api')->json('GET', "/api/server/details/4?token=$token");
        
        $response->seeStatusCode(403);

    }
    
    /**
     * A test to validate the correct 
     * HTTP 200 is returned when updating a server with only connection_name
     * and response is in the correct format
     * @return void
     */
    public function testUpdateServerConnectionName(){
        
        //Used to to login to get token
        $token = $this->login();
        
        $user = User::where('email', $this->emailOfTestUser)->first();
        $data = [
            "connection_name"=> "Test Update", 
            ];
        $response = $this->actingAs($user, 'api')->json('PUT', "/api/server/update/1?token=$token", $data);
        
        $response->seeStatusCode(200);
        $response->seeJsonStructure([
            'server' => 
                [
                    'id',
                    'created_at',
                    'updated_at',
                    'connection_name',
                    'connection_method',
                    'hostname',
                    'port',
                    'username',
                    'user_id'
                ]
        ]);

    }
    
        /**
     * A test to validate the correct 
     * HTTP 200 is returned when updating a server with only connection_method
     * and response is in the correct format
     * @return void
     */
    public function testUpdateServerConnectionMethod(){
        
        //Used to to login to get token
        $token = $this->login();
        
        $user = User::where('email', $this->emailOfTestUser)->first();
        $data = [
            "connection_method"=> "SFTP", 
            ];
        $response = $this->actingAs($user, 'api')->json('PUT', "/api/server/update/1?token=$token", $data);
        
        $response->seeStatusCode(200);
        $response->seeJsonStructure([
            'server' => 
                [
                    'id',
                    'created_at',
                    'updated_at',
                    'connection_name',
                    'connection_method',
                    'hostname',
                    'port',
                    'username',
                    'user_id'
                ]
        ]);

    }
    
}
