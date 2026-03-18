<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Mail\PasswordResetMail;
use App\Models\VerificationCode;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class APIAuthController extends Controller
{
     //تابع تسجيل دخول
     public function login(Request $request)
     {
         $validated = $request->validate([
             'email' => ['required','string','email'],
             'password' => ['required','string', 'min:6'],
         ]);
 
         if(!Auth::attempt($request->only('email', 'password'))){
             return response([
                 'error' => 'The Provided credentials does not match'
             ], 422);
         } 
         
         $user = User::where('email',$request->email)->first();
 
         return response([
             'user' => new UserResource($user),
             'token' => $user->createToken('API token of '.$user->name)->plainTextToken
         ]);
     }
 
 
 
 
 
 
     //تابع انشاء حساب
     public function register(Request $request)
     {
         $validated = $request->validate([
             'name' => ['required', 'string', 'max:255'],
             'l_name' =>  ['required', 'string', 'max:255'],
             'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
             'password' => ['required', 'string', 'min:6', 'confirmed'],
             'university' => ['nullable', 'string'] 
         ], [
             'email.unique' => 'The email has already been taken.',
         ]);
     
         try {
             $user = User::create([
                 'id' => $request->id,
                 'role' => 0,
                 'name' => $request->name,
                 'l_name' => $request->l_name,
                 'email' => $request->email,
                 'password' => Hash::make($request->password),
                 'university' => $request->university,
             ]);
         
         } catch (IlluminateDatabaseQueryException $e) {
             if ($e->errorInfo[1] == 1062) {
                 return response()->json(['message' => 'The email has already been taken.'], 400);
             }
         }
     
         return response([
             'user' => new UserResource($user),
             'token' => $user->createToken('API token of '.$user->name)->plainTextToken
         ]);
     }
     

     //تابع تسجيل خروج
     public function logout()
     {
         Auth::user()->currentAccessToken()->delete();
         return response([
             'success' => true,
             'message'=>'goodbye...'
         ]);
     }
 

     
   
    public function send_password_reset_email(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
        ]);
    
        $verification_code = VerificationCode::firstOrNew(['email' => $request->email]);
        if (!$verification_code->exists) {
            $verification_code->code = mt_rand(1000, 9999);
        }
        $code_time = Carbon::parse($verification_code->created_at);
        $resend_time = $code_time->addMinutes(env('CODE_RESEND_TIME'));
        if (Carbon::now() < $resend_time) {
            throw new BadRequestException(__("error_messages.Can't send right now, please wait"));
        }
        $verification_code->created_at = Carbon::now();
        $verification_code->save();
        $data = [
            'code' => $verification_code->code,
            'message' => 'Verification code has been generated.'
        ];
        return response()->json($data, 200);
    }
    public function reset_password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'    => ['required', 'email', 'exists:users,email'],
            'code'     => ['required'],
            'password' => ['required', 'confirmed', 'min:6'],
        ]);
    
        if ($validator->fails()) {
            throw ValidationException::withMessages($validator->errors()->toArray());
        }
        
            $verification_code = VerificationCode::where('email', $request->email)
                ->where('code', $request->code)
                ->first();
        
            if (!$verification_code) {
                throw ValidationException::withMessages(['number' => 'error_messages.The number must not be greater than ' . $max_number]);
            }
        
            $user = User::where('email', $verification_code->email)->first();
            $user->update([
                'password' => Hash::make($request->password), 
            ]);
            $verification_code->delete();
            $token = $user->createToken('Sanctum')->plainTextToken;
        
            return response()->json([
                'user'  => new UserResource($user),
                'token' => $token,
            ], 200);
        }
}

