<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //
   public function index(){
       $user = User::all();
       return $user;
   }

   public function create(Request $request){
       $validated = $request->validate([
           'name' => 'required',
           'email' => 'required|email:rfc,dns|unique:users,email',
           'password' => 'required',
       ]);
        $hashedPassword = password_hash($request->input('password'), PASSWORD_DEFAULT);
        $user = User::Create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password'=> $hashedPassword,
            'level' => 3
        ]);
        $token = generateToken($user['id'], $user['level']);
        $data = [
            'name' => $user['name'],
            'email' => $user['email'],
            'token' => $token

        ];
        $response = createSuccessResponse(200, 'success','User has been created', $data);
        return $response;
   }

   public function session(Request $request){
    //    $validated = $request->validate([
    //        'email' => 'email:rfc,dns|required',
    //        'password' => 'required'
    //    ]);
        $validator = Validator::make($request->all(), [
            'email' => 'required|email:rfc,dns',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            
            $response = createFailedResponse(400,"error", "Failed to login", $validator->errors());
            return $response;
        }
       
       $user = User::Where('email', $request->input('email'))->first();
        if (!$user) {
            # code...
            $errorAuth = [ "auth" => ["Wrong Email"]];
            $response = createFailedResponse(400, 'error', 'Login Fail', $errorAuth);
            return response($response, 400);
        }
        if (!password_verify($request->input('password'), $user['password'])) {
            $errorAuth = [ "auth" => ["Wrong Password"]];
            $response = createFailedResponse(400, 'error', 'Login fail', $errorAuth);
            return $response;
        }
        $token = generateToken($user['id'], $user['level']);
        $data = [
            'id' => $user['id'],    
            'name' => $user['name'],
            'email' => $user['email'],
            'token' => $token
        ];
        $response = createSuccessResponse(200, 'success', 'Login success', $data);
        $response->withCookie(cookie('token', $data['token'], 10));
        return $response;
        // return $response->withCookie(cookie('token', $data['token'],2));
   }

   public function get(Request $request, $id = null){
        $user = User::Where('id', $id)->first();
        $userInfoSession = $request->session()->get('user_info');
        // return 'user_id : ' . $user['id'] . 
        // 'session user_id : ' . $userInfoSession->user_id;
        if ($id != $userInfoSession->user_id || $user['level'] == 1) {
            $response = unauthorizedResponse();
            return response($response, 401);
        }
        if (!$user) {
            # code...
            $response = createFailedResponse(400, 'error', 'User not found by that id', null);
            return response($response,$response['code']);
        }
        return createSuccessResponse(200, 'success', 'Get user success', $user);
   }    

}
