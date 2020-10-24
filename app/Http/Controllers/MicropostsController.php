<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MicropostsController extends Controller
{
    public function index()
    {
        $data = [];
        if (\Auth::check()) { // 認証済みの場合
            // 認証済みユーザを取得
            $user = \Auth::user();
            // ユーザの投稿の一覧を作成日時の降順で取得
            $microposts = $user->microposts()->orderBy('created_at', 'desc')->paginate(1);

            $data = [
                'user' => $user,
                'microposts' => $microposts,
                ];
            }
                    // Welcomeビュー
            return view('welcome', $data);
        }
        
        
            public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|max:255',
        ]);

        // authユーザーの投稿をstore（Request $request）
        $request->user()->microposts()->create([
            'content' => $request->content,
        ]);

        return back();
    }
    
        public function destroy($id)
    {
        // id値で取得
        $micropost = \App\Micropost::findOrFail($id);

        // auth中のユーザーのみアクセス可
        if (\Auth::id() === $micropost->user_id) {
            $micropost->delete();
        }

        return back();
    }

}
