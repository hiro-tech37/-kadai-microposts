<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User; // Userモデルを使用

class UsersController extends Controller
{
    public function index()
    {   
        //モデルへアクセス
        // ユーザ一覧をidの降順で取得
        $users = User::orderBy('id', 'desc')->paginate(1);

        //viewへアクセス
        // ユーザ一覧ビューでそれを表示
        return view('users.index', [
            'users' => $users,
        ]);
    }
    
    public function show($id)
    {   
        //model
        
        //ユーザーidで取得
        $user = User::findOrFail($id);

        //投稿数カウント
        $user->loadRelationshipCounts();

        // ユーザの投稿一覧を作成日時の降順で取得
        $microposts = $user->microposts()->orderBy('created_at', 'desc')->paginate(10);
        
        //view
        // ユーザ詳細ビューでそれを表示
        return view('users.show', [
            'user'       => $user,
            'microposts' => $microposts
        ]);
    }
}
