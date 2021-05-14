<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

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
        ]);
        $data = [
            'name' => $user['name'],
            'email' => $user['email'],
            'token' => "tokentoken"

        ];
        $response = createSuccessResponse(200, 'success','User has been created', $data);
        return $response;
   }

   public function session(Request $request){
       $validated = $request->validate([
           'email' => 'email:rfc,dns|required',
           'password' => 'required'
       ]);
       $user = User::Where('email', $request->input('email'))->first();
        if (!$user) {
            # code...
            $response = createFailedResponse(400, 'error', 'Login Fail', 'email not found');
            return response($response, 400);
        }
        if (!password_verify($request->input('password'), $user['password'])) {
            $response = createFailedResponse(400, 'error', 'Login fail', 'Wrong Password');
            return response($response, 400);
        }
        $data = [
            'name' => $user['name'],
            'email' => $user['email'],
            'token' => 'token'
        ];
        $response = createSuccessResponse(200, 'success', 'Login success', $data);
        return response($response,200);
   }

}
