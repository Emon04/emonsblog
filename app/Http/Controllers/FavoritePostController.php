<?php

namespace App\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoritePostController extends Controller
{
    public function add($post){
        $user = Auth::user();
        $isFavorite = $user->favorite_posts()->where('post_id', $post)->count();
        if($isFavorite == 0){
            $user->favorite_posts()->attach($post);
            Toastr::success('Post Successfully added to your Favorite list :)', 'Success');
            return redirect()->back();

        }else{
            $user->favorite_posts()->detach($post);
            Toastr::success('Post Successfully removed to your Favorite list :)', 'Success');
            return redirect()->back();
        }
    }
}
