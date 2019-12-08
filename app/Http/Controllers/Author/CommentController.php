<?php

namespace App\Http\Controllers\Author;

use App\Comment;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function index()
    {
        $u_id = Auth::user()->id;
        $data['comments'] = Comment::with('post')->where('user_id',$u_id)->get();

        return view('author.comments',$data);
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id)->delete();
        if ($comment->post->user->id == Auth::id()){
            $comment->delete();
            Toastr::success('Comment Successfully Deleted :)', 'Success');
        }else{
            Toastr::error('Sorry!! you cannot delete it', 'Error');
        }
        return redirect()->back();
    }
}
