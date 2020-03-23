<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reaction extends Model
{
  /** idのインクリメントを無効**/
  public $incrementing = false;
  // update_at, create_atを無効
  public $timestamps = false;

  //Relation
  public function toUserId()
  {
    //受けて側の情報を取得
    // belongsTo(相手のモデル名、自モデルのID、相手のID)を参照する
    return $this->belongsTo('App\User', 'to_user_id', 'id');
  }

  public function fromUserId()
  {
    //送り手側の情報
    return $this->belongsTo('App\User', 'from_user_id', 'id');
  }
}
