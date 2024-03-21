<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Auth;
use Hash;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Register user
     * 
     * @param $request
     * @return JsonReponse
     */

     public function register(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'email'=> 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8'
        ]);

        if($validator->fails()){
            return response()->json([$validator->errors()],422);
        }

        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password)
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['data'=>$user,'access_token'=>$token,'token_type'=>'Bearer'],201);

     }

     /**
      * Authentificate user
      *
      *@param $request
      *@return $JsonResponse
      */

      public function login (Request $request){
        if(!Auth::attempt($request->only('email','password')))
        {
            return response()->json(['message'=>'Unauhorized']);
        }

        $user = User::where('email',$request['email'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message'=> 'Hi '.$user.' welcome to our system, ','access_token'=> $token,
            'token_type'=>'Bearer'
        ],200);
      }

      /*
      * Logout user
      * @return array
      */

      public function logout(Request $request){
       $user = Auth::user();
       $user->tokens()->delete();

        return response()->json(['message'=>'You are logged out'],200);
      }
}
