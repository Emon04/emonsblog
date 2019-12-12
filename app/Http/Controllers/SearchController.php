<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
class SearchController extends Controller
{
    public function search(Request $request){
        $query = $request->input('query');
        $posts = Post::where('title','LIKE', '%'.$query.'%')->get();
        return view('search', compact('posts', 'query'));

    }
}
