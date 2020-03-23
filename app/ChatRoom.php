<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatRoom extends Model
{

  // Chatルームのユーザと1対多の関係をhasManyで結合する
  public function chatRoomUsers()
  {
    return $this->hasMany('App\ChatRoomUser');
  }

  // ChatMessageとも1対多の関係性にする
  public function chatMessages()
  {
    return $this->hasMany('App\ChatMessage');
  }
}
