<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Reaction;
use App\Constant\Status;
use Log;

class ReactionController extends Controller
{
  public function create(Request $request)
  {

    // 🟡POST通信で渡ってきた内容をログに出力している
    // Log::debug($request);

    //POST通信で渡って$request(値)を変数にセット
    $to_user_id = $request->to_user_id;
    $like_status = $request->reaction;
    $from_user_id = $request->from_user_id;

    // 渡ってきた内容がStatusファイルの内容と一致しているか確認
    if ($like_status === 'like'){
      $status = Status::LIKE;
    }else{
      $status = Status::DISLIKE;
    }

    $checkReaction = Reaction::where([
      ['to_user_id', $to_user_id],
      ['from_user_id', $from_user_id],
    ])->get();

    if($checkReaction->isEmpty()){

      //Reactionsテーブルをインスタンス化
      $reaction = new Reaction();

      // 上のPOST通信のデータを変数化したものをインスタンス化した
      // Reactionテーブルに代入
      $reaction->to_user_id = $to_user_id;
      $reaction->from_user_id = $from_user_id;
      $reaction->status = $status;

      $reaction->save();
    }
  }
}
