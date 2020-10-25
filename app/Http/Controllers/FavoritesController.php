<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class FavoritesController extends Controller
{
    //お気に入りアクション
    
    public function store($id)
    {
        // 認証済みユーザ（閲覧者）が、 idのmicropostをfavoする
        \Auth::user()->favo($id);
        // 前のURLへリダイレクトさせる
        return back();
    }


    public function destroy($id)
    {
        // 認証済みユーザ（閲覧者）が、 idのmicropostをアンfavoする
        \Auth::user()->unfavo($id);
        // 前のURLへリダイレクトさせる
        return back();
    }
}
