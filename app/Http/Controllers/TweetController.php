<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TweetController extends Controller
{
    public function create()
    {
        return view('tweets.create');
    }

}
