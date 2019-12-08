<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Subscriber;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    public function index() {
        $subscribers = Subscriber::latest()->get();
        return view('admin.subscriber', compact('subscribers'));
    }
    public function destroy($subscriber){
        $subscriber = Subscriber::findOrFail($subscriber)->delete();
        Toastr::success('Subscriber Successfully Deleted','Success');
        return redirect()->back();
    }

    public function userList(){
        $data['users'] = User::where('role_id',3)->get();
        return view('admin.users',$data);
    }
    public function userStatus(Request $request, $id){
        $user = User::findOrFail($id);
        $user->status = $request->status;
        $user->save();
        Toastr::success('Status Successfully Updated','Success');
        return redirect()->back();
    }
}
