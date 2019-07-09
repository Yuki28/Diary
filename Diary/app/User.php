<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */  
    //ホワイトリスト（セキュリティ）
    protected $fillable = [
        'name', 'email', 'password','age',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    function diaries(){//多になるテーブル名を使うのが一般的
        return $this->hasmany('App\Diary');

    }
}
    