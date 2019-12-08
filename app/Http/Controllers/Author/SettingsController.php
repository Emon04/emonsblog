<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class SettingsController extends Controller
{
    public function index(){
        return view('author.settings');

    }
    public function updateProfile(Request $request){
        $this->validate($request,[
            'name' => 'required',
            'email' => 'required|email',
            'image' => 'required|image',
        ]);
        $image = $request->file('image');
        $slug = strtolower($request->name);
        $user = User::findOrFail(Auth::id());
        if(isset($image)){
            $currentDate = Carbon::now()->toDateString();
            $imageName = $slug.'-'.$currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();
            if(Storage::disk('public')->exists('profile')){
                Storage::disk('public')->makeDirectory('profile');
            }
//            for deleting old images from folder
            if(Storage::disk('public')->exists('profile/'.$user->image)){
                Storage::disk('public')->delete('profile/'.$user->image);
            }
            $profile = Image::make($image)->resize(500,500)->save($imageName,90);
            Storage::disk('public')->put('profile/'.$imageName,$profile);

        }else{
            $imageName = $user->image;
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->image = $imageName;
        $user->about = $request->about;
        $user->save();
        Toastr::success('Profile Updated Successfully :)', 'Success');
        return redirect()->back();
    }

    public function updatePassword(Request $request){
        $this->validate($request, [
            'old_password' => 'required',
            'password' => 'required |confirmed',
        ]);

        $hashedPassword = Auth::user()->password;
        if (Hash::check($request->old_password, $hashedPassword)){
            if(!Hash::check($request->password, $hashedPassword)){
                $user = User::find(Auth::id());
                $user->password = Hash::make($request->password);
                $user->save();

                Toastr::success('Password Successfully Changed', 'Success');
                Auth::logout();
                return redirect()->back();
            }else{
                Toastr::error('New Password cannot be the same as old password', 'Error');
                return redirect()->back();
            }
        }else{
            Toastr::error('Current Password is not matched', 'Error');
        }

    }
}
