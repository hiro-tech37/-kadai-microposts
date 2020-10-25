<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Micropost extends Model
{
    //属性を固定
    protected $fillable = ['content'];
   
   //Userモデルとの関係をメソッド化
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    //お気に入り機能
    //belongsToMany関係をメソッド化
    public function favorite_users()
    {
        return $this->belongsToMany(User::class, 'favorites', 'micropost_id', 'user_id')->withTimestamps();
    }
    
    
}
