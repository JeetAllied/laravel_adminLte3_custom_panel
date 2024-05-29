<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function login(Request $request)
    {
        if($request->isMethod('post'))
        {
            try {
                $data = $request->all();
                $rules = [
                    'email'=>'required|email',
                    'password'=>'required',
                ];

                $messages = [
                    'email.required'=>'Email is required.',
                    'email.email'=>'Please Provide valid Email.',
                    'password'=>'Password is required.'

                ];

                $validator = Validator::make($data,$rules,$messages);
                if($validator->fails())
                {
                    return redirect()->back()->withErrors($validator);
                }

                if(Auth::guard('admin')->attempt(['email'=>$data['email'],'password'=>$data['password']]))
                {
                    $notification = array(
                        'msg' => 'Admin user logged in successfully.',
                        'alert-type' => 'success'
                    );
                    return redirect('admin/dashboard')->with($notification);
                }
                else
                {
                    return redirect()->back()->with('message','Invalid Email or Password.');
                }
            }
            catch(\Exception $e)
            {
                return redirect()->back()->with('message',$e->getMessage());
            }

        }
        return view('admin.login');
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        $notification = array(
            'msg' => 'Admin user logged out successfully.',
            'alert-type' => 'success'
        );
        return redirect()->route('admin.login')->with($notification);
    }
}
