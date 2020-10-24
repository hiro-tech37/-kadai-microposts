<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    
    //MicropostとのhasMany関係をメソッド化
    public function microposts()
    {
        return $this->hasMany(Micropost::class);
    }
    
    //User同士のbelonbsToMany関係をメソッド化。フォローしてるorされている
    public function followings()
    {
        //belongsToMany() では、第一引数に得られるModelクラス（User::class) を指定し、
                                //第二引数に中間テーブル（user_follow）を指定し
                                //第三引数には中間テーブルに保存されている自分のidを示すカラム名（user_id）を指定し
                                //第四引数には中間テーブルに保存されている関係先のidを示すカラム名（follow_id）を指定
        
        return $this->belongsToMany(User::class, 'user_follow', 'user_id', 'follow_id')->withTimestamps();
    }


    public function followers()
    {
        return $this->belongsToMany(User::class, 'user_follow', 'follow_id', 'user_id')->withTimestamps();
    }
    
    //ここまでbelongsToManyのメソッドを定義。
    
    //ここからフォロー・アンフォローをメソッド化
    
    public function follow($userId)
    {
        // すでにフォローしているか
        $exist = $this->is_following($userId);
        // 相手が自分自身かどうか
        $its_me = $this->id == $userId;

        if ($exist || $its_me) {  //または
            return false;
            
        } else {
            $this->followings()->attach($userId); //アタッチ()
            return true;
        }
    }


    public function unfollow($userId)
    {
        // すでにフォローしているか
        $exist = $this->is_following($userId);
        // 相手が自分自身かどうか
        $its_me = $this->id == $userId;

        if ($exist && !$its_me) { //$exist かつ not $its_me
        
            $this->followings()->detach($userId);  //デタッチ()
            return true;
        } else {
            return false;
        }
    }


    public function is_following($userId)
    {
        // フォロー中ユーザの中に $userIdのものが存在するか
        return $this->followings()->where('follow_id', $userId)->exists();
    }


    //「feed＝外部から刻々と配信されてくるデータを時系列で一覧に。」
    //followings()と自分のidを引っ張ってくる
    public function feed_microposts()
    {
        // このユーザがフォロー中のユーザのidを取得して配列にする。「pluck=摘む」
        $userIds = $this->followings()->pluck('users.id')->toArray();
        // このユーザのidもその配列に追加
        $userIds[] = $this->id;
        // それらのユーザが所有する投稿に絞り込む
        return Micropost::whereIn('user_id', $userIds);
    }
    
    
    //hasManyなmicropostsの数カウントするメソッド
    public function loadRelationshipCounts()
    {
        $this->loadCount(['microposts', 'followings', 'followers']);
    }
    
    
}
