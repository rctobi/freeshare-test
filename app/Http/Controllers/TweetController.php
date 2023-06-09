<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tweet;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\TweetRequest;
use Illuminate\Support\Facades\DB;

class TweetController extends Controller
{
    /**
     * トップページを表示
     * @return view
     */
    public function index()
    {
        $tweets = Tweet::orderBy('created_at', 'desc')->get();
        return view('tweets.index', ['tweets' => $tweets]);
    }

    /**
     * 投稿ページを表示
     * @return view
     */
    public function create()
    {
        return view('tweets.create');
    }
    
    /**
     * 投稿データを登録
     * @return redirect
     */
    public function store(TweetRequest $request)
    {
        $inputs = $request->all();
        
        // 画像があった場合の処理
        if($file = $request->image) {
            $fileName = date('Ymd_His').'_'. $file->getClientOriginalName();
            $target_path = public_path('storage/');
            $file->move($target_path, $fileName);
            $inputs = $request->except(['image']); // 'image'キーを一度除外する
            $inputs['image'] = $fileName; // 'image'キーにファイル名を追加する
        }
        // データの登録
        Tweet::create($inputs);

        session()->flash('message', '新しい投稿が完了しました。');
        return redirect()->route('tweet.index');
    }
    
    /**
     * 投稿詳細ページを表示
     * @param int $id
     * @return view
     */
    public function show(int $id)
    {
        $tweet = Tweet::find($id);
        if(is_null($tweet)) {
            session()->flash('message', '投稿データがありません。');
            return redirect(route('tweet.index'));
        }
        return view('tweets.detail', ['tweet' => $tweet]);
    }
    
    /**
     * 編集ページを表示
     * @param int $id
     * @return view
     */
    public function edit(int $id)
    {
        $tweet = Tweet::find($id);
        
        // 直打ち対策
        if(Auth::id() != $tweet->user_id) {
            return redirect('index');
        }
        
        if(is_null($tweet)) {
            session()->flash('message', '投稿データがありません。');
            return redirect(route('tweet.index'));
        }
        return view('tweets.edit', ['tweet' => $tweet]);
    }
    
    /**
     * 編集データを登録
     * @return redirect
     */
    public function update(TweetRequest $request)
    {
        $inputs = $request->all();
        
        // 画像があった場合の処理
        if($file = $request->image) {
            $fileName = date('Ymd_His').'_'. $file->getClientOriginalName();
            $target_path = public_path('storage/');
            $file->move($target_path, $fileName);
            $inputs = $request->except(['image']); // 'image'キーを一度除外する
            $inputs['image'] = $fileName; // 'image'キーにファイル名を追加する
        }
        
        $tweet = Tweet::find($inputs['id']);
        $tweet->fill([
            'content' => $inputs['content'],
            'image' => $inputs['image'] ?? null,
            'user_id' => $inputs['user_id'],
        ]);
        
        // データの更新
        $tweet->save();

        session()->flash('message', '新しい投稿が完了しました。');
        return redirect()->route('tweet.index');
    }
    
    /**
     * 投稿データの削除
     * @param int $id
     * @return view
     */
    public function destroy(int $id)
    {
        if(empty($id)) {
            session()->flash('message', 'データを削除しました。');
            return redirect(route('tweet.index'));
        }
        
        try {
            Tweet::destroy($id);
        } catch(\Throwable $e) {
            \Log::error($e);
            abort(500);
        }
        session()->flash('message', 'データを削除しました。');
        return redirect(route('tweet.index'));
    }
}
