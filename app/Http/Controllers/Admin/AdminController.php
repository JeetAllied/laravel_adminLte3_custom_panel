<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
//use Intervention\Image\Image;
use Intervention\Image\Laravel\Facades\Image;

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

    public function viewUpdatePassword()
    {
        return view('admin.update_password');
    }

    public function checkCurrentPassword(Request $request)
    {
        try {
            $rules = [
                'currentPwd'=>'required',
            ];
            $messages = [
                'currentPwd.required'=>'Please enter current password.'
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if($validator->fails())
            {
                return response()->json($validator->messages(), 422);
            }
            if(Hash::check($request->currentPwd, Auth::guard('admin')->user()->password))
            {
                return response()->json(['success'=>'true','message' => 'Successfully Done.'], 200);
            }
            return response()->json(['success'=>'false','message' => 'Sorry current password does not match.'], 400);

        }
        catch(\Exception $e)
        {
            return response()->json(['success'=>'false','message' => $e->getMessage()], $e->getCode());
        }
    }

    public function updatePassword(Request $request)
    {
        try {
            $rules = [
              'current_password'=> 'required',
              'new_password'=>'required|confirmed',
            ];

            $messages = [
                'current_password.required'=>'Current password is required.',
                'new_password.required'=> 'New password is required.',
                'new_password.confirmed'=> 'New password and confirm password must be same.',
            ];

            $validator = Validator::make($request->all(),$rules, $messages);
            if($validator->fails())
            {
                return redirect()->back()->withErrors($validator);
            }
            if(Hash::check($request->current_password, Auth::guard('admin')->user()->password))
            {
                //update the password
                Admin::where('id',Auth::guard('admin')->user()->id)->update(['password'=>bcrypt($request->new_password)]);
                $notification = array(
                    'msg' => 'Admin password updated successfully.',
                    'alert-type' => 'success'
                );
                return redirect()->route('admin.dashboard')->with($notification);
            }
            else
            {
                $notification = array(
                    'msg' => 'Current password does not match.',
                    'alert-type' => 'error'
                );
                return redirect()->back()->with($notification);
            }

        }
        catch(\Exception $e)
        {
            $notification = array(
                'msg' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function viewUpdateProfile()
    {
        return view('admin.update_profile');
    }

    public function updateProfile(Request $request)
    {
        try {
            $rules = [
                'name'=>'required|regex:/^[\pL\s\-]+$/u', //alphabets with space validation
                'mobile'=>'required|numeric',
                'profile_image'=>'image',
            ];

            $messages = [
                'name.required'=>'Admin name is required.',
                'name.regex'=> 'Please enter valid admin name.',
                'mobile.required'=> 'Mobile number is required.',
                'mobile.numeric'=> 'Mobile number must be numeric only.',
                'profile_image.image'=> 'Valid profile image is required.'
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if($validator->fails())
            {
                return redirect()->back()->withErrors($validator);
            }

            $data = array(
                'name'=>$request->name,
                'mobile'=>$request->mobile,
            );

            //upload image
            if($request->hasFile('profile_image'))
            {
                $imgTemp = $request->file('profile_image');
                if($imgTemp->isValid()) {
                    //get image extension
                    $extension = $imgTemp->getClientOriginalExtension();
                    //generate new image
                    $imgName = rand(111,99999).'.'.$extension;
                    $imgDir = 'admin/images/photos';
                    if (!file_exists($imgDir)) {
                        mkdir($imgDir, 0777, true);
                    }
                    $imagePath = $imgDir."/".$imgName;
                    $image = Image::read($imgTemp);
                    $image->save(public_path($imagePath));

                    $data = array(
                        'name'=>$request->name,
                        'mobile'=>$request->mobile,
                        'image'=>$imagePath,
                    );
                }
            }

            Admin::where('id',Auth::guard('admin')->user()->id)->update($data);

            $notification = array(
                'msg'=> 'Admin profile updated successfully.',
                'alert-type'=>'success',
            );
            return redirect()->route('admin.dashboard')->with($notification);
        }
        catch(\Exception $e)
        {
            $notification = array(
                'msg' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
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
