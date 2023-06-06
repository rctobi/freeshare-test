<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tweet;
use Illuminate\Support\Facades\Auth;
class TweetController extends Controller
{
    public function index()
    {
        $tweets = Tweet::all();
        return view('tweets.index', ['tweets' => $tweets]);
    }

    public function create()
    {
        return view('tweets.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|min:3|max:100',
            'image' => 'file|mimes:jpeg,jpg,png',
        ],[
            'content.required' => 'コンテンツは必須ですよ！',
        ]);

        $tweet = new Tweet();

        if($file = $request->image) {
            $fileName = date('Ymd_His').'_'. $file->getClientOriginalName();
            $target_path = public_path('storage/');
            $file->move($target_path, $fileName);
        } else {
            $fileName = null;
        }

        $tweet->content = $request->content;
        $tweet->image = $fileName;
        $tweet->user_id = Auth::id();

        $tweet->save();

        return redirect()->route('tweet.create');
    }

}
