<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use Illuminate\Support\Facades\Log;

class CommentController extends Controller
{
    public function store(CommentRequest $request)
    {
        $inputs = $request->all();

        try {
            Comment::create($inputs);
        } catch(\Throwable $e) {
            Log::error($e);
            abort(500);
        }

        session()->flash('message', 'コメント投稿が完了しました。');
        return redirect()->route('tweet.show', $request->tweet_id);
    }
}

// $comment = new Comment();
// $comment->user_id = Auth::id();
// $comment->tweet_id = $tweet->id;
// $comment->content = $request->content;

// $comment->save();
