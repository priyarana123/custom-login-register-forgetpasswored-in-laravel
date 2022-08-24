<?php

namespace App\Http\Controllers;

use Auth;
use Hash;
use Session;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;


class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }
    public function login(Request $request)
        {
        //  dd($request->all());
          $request->validate([
            'email'=>'required',
             'password'=>'required'
          ]);
          if(Auth::attempt($request->only('email','password'))){
            return redirect('home');
        }
        return redirect('login')->withError('Login details are not valid');
        
        
         
        }
  
    public function register_view()
    {
        return view('auth.register');
    }
    public function register(Request $request){
        $request->validate([
            'name'=>'required',
            'email'=>'required|unique:users|email',
            'password'=>'required|confirmed',
        ]);
        User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),

        ]);
if(Auth::attempt($request->only('email','password'))){
    return redirect('home');
}
return redirect('register')->withError('Error');


    }
    public function home(){
        return view('home');
    }
    public function logout()
    {
        Session::flush();
        Auth::logout();
        return redirect('/');

    }
    public function getEmail()
  {

     return view('auth.email');
  }
  public function postEmail(Request $request)
  {
    $request->validate([
        'email' => 'required|email|exists:users',
    ]);
    $token = Str::random(64);
    DB::table('password_resets')->insert([
        'email' => $request->email,
        'token' => $token,
        'created_at' => Carbon::now()
    ]);

    Mail::send('auth.verify', ['token' => $token], function($message) use($request){
        $message->to($request->email);
        $message->from(env('MAIL_FROM_ADDRESS'), env('APP_NAME'));
        $message->subject('Reset Password');
    });

      return back()->with('message', 'We have e-mailed your password reset link!');
  }
  public function ResetPassword($token) {
    return view('auth.forget-password-link', ['token' => $token]);
}

public function ResetPasswordStore(Request $request) {
    $request->validate([
        'email' => 'required|email|exists:users',
        'password' => 'required|string|min:8|confirmed',
        'password_confirmation' => 'required'
    ]);

    $update = DB::table('password_resets')->where(['email' => $request->email, 'token' => $request->token])->first();

    if(!$update){
        return back()->withInput()->with('error', 'Invalid token!');
    }

    $user = User::where('email', $request->email)->update(['password' => Hash::make($request->password)]);

    // Delete password_resets record
    DB::table('password_resets')->where(['email'=> $request->email])->delete();

    return redirect('login')->with('message', 'Your password has been successfully changed!');
}
}
