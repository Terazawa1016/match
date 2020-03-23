<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatRoomUser extends Model
{

  // $filableで二つの指定したフィールドを設定
  protected $fillable = ['chat_room_id', 'user_id'];

  public function chatRoom()
  {
    return $this->belongsTo('App\ChatRoom');
  }

  public function user()
  {
    return $this->belongsTo('App\User');
  }

}
