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
    
    
}
