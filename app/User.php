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
        'name', 'email', 'password', 'self_introduction,', 'sex', 'img_name'
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

    public function toUserId()
    {
      /**hasMany(相手のモデル名,相手のモデルのID,自分のモデルのID)
      をくっつける(1から多)**/
      return $this->hasMany('App\Reaction', 'to_user_id', 'id');
    }

    public function fromUserId()
    {
      /**hasMany(相手のモデル名,相手のモデルのID,自分のモデルのID)
      をくっつける**/
      return $this->hasMany('App\Reaction', 'from_user_id', 'id');
    }

    public function chatMessages()
    {
      return $this->hasMany('App\ChatMessage');
    }

    public function chatRoomUsers()
    {
      return $this->hasMany('App\ChatRoomUser');
    }
}
