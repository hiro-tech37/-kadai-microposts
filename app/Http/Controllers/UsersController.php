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
        // idの値でユーザを検索して取得
        $user = User::findOrFail($id);

        //view
        // ユーザ詳細ビューでそれを表示
        return view('users.show', [
            'user' => $user,
        ]);
    }
}
