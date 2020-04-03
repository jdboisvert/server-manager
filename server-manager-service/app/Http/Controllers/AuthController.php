<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;
use Laravel\Lumen\Routing\Controller as BaseController;

/**
 * Used to handle the login and registering of the service
 */ 
class AuthController extends Controller
{
    
    /**
     * The request instance.
     *
     * @var \Illuminate\Http\Request
     */
    private $request;

    /**
     * Create a new controller instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function __construct(Request $request) {
        $this->request = $request;
    }
    
    /**
     * Create a new user.
     *
     * @param  Request  $request
     * @return Response
     */
    public function register(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ]);

        try {

            $user = new User;
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $plainPassword = $request->input('password');
            $user->password = Hash::make($plainPassword);

            $user->save();

            return response()->json(['user' => $user, 'message' => 'CREATED'], 201);

        } catch (\Exception $e) {
            //return error message
            return response()->json(['message' => 'User Registration Failed!'], 409);
        }

    }
    
    /**
     * Used to generate a token based on the given user
     * @param $user
     * @return string for the token generated
     */
    protected function generateJwt(User $user) {
        $payload = [
            'iss' => "server_manager",
            'sub' => $user->id, 
            'iat' => time(),  
            'exp' => time() + 60*60 
        ];

        return JWT::encode($payload, env('JWT_SECRET'));
    } 
    
    /**
     * Get a JWT via given credentials.
     *
     * @param  Request  $request
     * @return Response
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->input('email'))->first();

        if (!$user) {
            return response()->json([
                'error' => 'Email does not exist.'
            ], 400);
        }

        if (Hash::check($this->request->input('password'), $user->password)) {
            return response()->json([
                'token' => $this->generateJwt($user)
            ], 200);
        }

        return response()->json([
            'error' => 'Email or password is wrong.'
        ], 400);

    }


}