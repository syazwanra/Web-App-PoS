<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Roles;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Carbon\Carbon;

class AuthController extends Controller
{
    //
        // Fungsi untuk Registrasi
        public function register(Request $request)
        {
            $request->validate([
                'name'=>'required',
                'email'=>'required|email|unique:users,email',
                'password'=>'required|min:6',
            ], [
                'required'=>'Data must be filled'
            ]);
    
            $rolesData = Roles::where('name', 'cashier')->first();
    
            $user = User::create([
                "name"=> $request->input('name'),
                "email"=> $request->input('email'),
                "password"=> Hash::make($request->input('password')),
                "role_id"=> $rolesData->id
            ]);
    
            $userData = User::with(['role'])->where('id', $user->id)->first();
            $token = JWTAuth::fromUser($user);

            $user->generateOtpCodeData();
            $token = JWTAuth::fromUser($user);

            Mail::to($user->email)->send(new RegisterMailSend($user));

            return response ([
                "message"=>"Registration was successful",
                "token" => $token,
                "data" => $userData
            ], 201);
        }

        public function generateOtp(Request $request){
            $request->validate([
                'email' => 'required|email'
            ]);
    
            $userData = User::where('email', $request->email)->first();
            $userData->generateOtpCodeData();
    
            Mail::to($user->email)->send(new RegisterMailSend($user));
            
            return response ([
                "message"=>"Otp code was successful be generate, please check your email"
            ], 201);
        }
    
        public function verifikasi(Request $request){
            $request->validate([
                'otp' => 'required'
            ]);
    
            //Cek otp yang diinput = otp data
            $otp_code = otpCode::where('otp', $request->input('otp'))->first();
            
            if(!$otp_code){
                return response ([
                    "message"=>"Otp code was not match"
                ], 404);
            }
            
            $now = Carbon::now();
            //otp code expired
    
            if($now > $otp_code->valid_until){
                return response ([
                    "message"=>"Otp code run-out of time, please regenerate",
                ], 404);
            }
    
            //Update di table user
            $user = User::find($otp_code->user_id);
            $user->email_verified_at = $now;
    
    
            $user->save();
    
            //delete
            $otp_code->delete();
    
            return response ([
                "message"=>"Successfully verification account",
            ], 200);
    
    
        }   

        //Fungsi Login
    public function login(Request $request)
    {
        $credentials = request(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Invalid User'], 401);
        }

        $user = User::with(['profile', 'role'])->where('email', $request['email'])->first();

        return response ([
            "message"=>"Login was successful",
            "token" => $token,
            "data" => $user
        ], 200);
    }

        //Fungsi me(getUser) berdasarkan api
    public function getUser()
    {
        $currentUser = auth()->user(); //user yang sedang login sekarang berdasarkan tokennya
        // $roleUser = auth()->user()->role->name;


        $userandProfile = User::with(['profile', 'role'])->find($currentUser->id);
        return response ([
            "message"=>"Get User Success",
            "data" => $userandProfile
        ], 200);   
    }

        //Fungsi Logout
    public function logout()
    {
        auth()->logout();

        return response()->json
        (
            [
                'message' => 'Successfully logged out'
            ]
        );
    }
}