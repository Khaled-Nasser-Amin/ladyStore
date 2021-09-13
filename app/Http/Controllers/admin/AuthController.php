<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Mail\ForgetPasswordEmail;
use App\Mail\SendCode;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest')->except(['logout','activeAccount','saveFile']);
    }


    //login
    public function index(){
        if(session()->has('super_admin') && session()->get('super_admin') == 1){
            session()->forget('super_admin');
            return redirect()->route('index_super_admin');
        }
        return view('admin.auth.login');
    }
    public function login(Request $request){
        $user=$this->login_validation($request);

        if(User::onlyTrashed()->where('email',$request->email)->first()){
            return redirect()->back()->withErrors(['email'=>__('text.This account deleted,contact us to restore it.')]);
        }
        if(!$user || $user->role == 'admin'){
            return redirect()->back()->withErrors(['email'=>__('text.These credentials do not match our records.')]);

        }

        if($user->activation != 1 ){
            $code=implode('',array_rand([0,1,2,3,4,5,6,7,8,9],6));
            $user->update(['code'=>$code]);
            $user->save();
            Mail::to($user->email)->send(new SendCode($user->code,$user->name));
            session()->put('data',$user);
            session()->put('time',time());
            session()->put('activeCodeField','');
            return redirect()->route('front.register');
        }
        $cred=$this->getCredentials($request);

        return  $this->loginCheck($request,$user,$cred);

    }


     //login super admin
     public function index_super_admin(){
        return view('admin.auth.login_super_admin');
    }
    public function login_super_admin(Request $request){

        $user=$this->login_validation($request);

        if(!$user || $user->role != 'admin'){
            return redirect()->back()->withErrors(['email'=>__('text.These credentials do not match our records.')]);
        }

        $cred=$this->getCredentials($request);
        return $this->loginCheck($request,$user,$cred);
    }

    protected function login_validation($request){
        $request->validate([
            'email' => 'required|email|exists:users'
        ]);

        $user=User::where('email',$request->email)->first();
        return $user;
    }

    protected function loginCheck($request,$user,$cred)
    {
        if (Hash::check($request->password,$user->password) && $user->two_factor_secret != null && $user->two_factor_recovery_codes != null){
            $request->session()->put([
                'login.id' => $user->getKey(),
                'login.remember' => $request->filled('remember'),
            ]);
            return view('admin.auth.two-factor-challenge');
        }else{
            if(Auth::guard('web')->attempt($cred,$request->remember_me ? 1 : 0))
            {
                return redirect(RouteServiceProvider::HOME);
            }else{
               return $this->faildAttemptPassword($request->email);
            }
        }
    }

    protected function faildAttemptPassword($email)
    {
        session()->flash('_old_input');
        session()->put('_old_input._token',csrf_token());
        session()->put('_old_input.email',$email);
        return redirect()->back()->withErrors(['email'=>__('text.This password does not match our records.')]);

    }

    protected  function getCredentials($request){
        return [
            'email'=>$request->email,
            'password'=>$request->password
        ];
    }



    //logout
    public function logout(){
        if(auth()->user()->role == 'admin'){
            session()->put('super_admin',1);
        }
        auth()->logout();
        return view('admin.auth.logout');
    }

    //forget password
    public function viewForget(){
        return view('admin.auth.forgetPassword');
    }

    public function messageAfterSendingEmailToResetPassword(Request $request){
        $request->validate([
            'email'=>'required|email|exists:users'
        ]);
        $key=Str::random();
        $email=$request->email;
        session()->put('email',$email);
        session()->put('key',$key);
        $user=User::where('email',$email)->first();

        Mail::to($email)->send(new ForgetPasswordEmail(route('viewResetPassword',$request->_token.$key),$user->name));
        return view('admin.emails.messageAfterSendingEmail');
    }

    public function viewResetPassword(Request $request,$token){
        if(session()->has('_token') && session()->has('key') && session()->get('_token').session()->get('key') == $token){
            return view('admin.auth.reset-password');
        }
        else{
            return abort(404);
        }
    }

    public function changePassword(Request $request){
        $request->validate([
            'password' => 'required|alpha_num|max:255|confirmed'
        ]);
        if (session()->has('email')){
            $user=User::where('email',session()->get('email'))->first();
            $password=bcrypt($request->password);
            $user->update(['password' => $password]);
            $user->save();
            session()->forget('email');
            auth()->login($user);
            return redirect('/admin/dashboard');
        }else{
            return abort(404);
        }
    }

}
