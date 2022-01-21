<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function register(Request $request)
    {

        $validator = Validator::make($request->all(),[
            'first_name' => 'required | string',
            'last_name' => 'required | string',
            'mobile' => 'required',
            'email' => 'required |email:rfc,dns',
            'age' => 'required',
            'gender' => 'required',
            'city' => 'required',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => false,
                "message" => $validator->errors(),
            ]);
        }

        try {

            $newUser = new User();

            $newUser->firstname = $request->first_name;
            $newUser->lastname  = $request->last_name;
            $newUser->mobile    = $request->mobile;
            $newUser->email     = $request->email;
            $newUser->age       = $request->age;
            $newUser->gender    = $request->gender;
            $newUser->city      = $request->city;

            $newUser->save();

            return response()->json([
                'status' => true,
                'message' => "User registered Successfully!",
            ], 200);

        } catch (\Throwable $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 200);
        }

    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email' => 'required | email:rfc,dns',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => false,
                "message" => $validator->errors(),
            ]);
        }


        try {

            $userDetail = User::where('email', $request->email)->where('password', $request->password)->first();

            if($userDetail)
            {
                return response()->json([
                    'status' => true,
                    'message' => "Successfully Login!",
                    'data' => [
                        'firstName' => $userDetail->firstname,
                        'lastName' => $userDetail->lastname,
                        'mobile' => $userDetail->mobile,
                        'email' => $userDetail->email,
                        'age' => $userDetail->age,
                        'gender' => $userDetail->gender,
                        'city' => $userDetail->city,
                    ]
                ], 200);
            }else{
                return response()->json([
                    'status' => false,
                    'message' => "Invalid email or Password Please check your login credentials!"
                ], 200);
            }

        } catch (\Throwable $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 200);
        }

    }

}
