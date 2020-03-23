<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Constant\Status;
use App\Reaction;
use App\User;
use\Auth;

class MatchingController extends Controller
{
  public static function index()
  {
    $got_reaction_ids = Reaction::where([
      //to_user_idが自分
      ['to_user_id', Auth::id()],

      //StatusインスタンスでLIKEの情報を取得
      ['status', Status::LIKE]

      //pluckは指定した値の情報を全て取得
      //plunkはLIKEしてくれた人のID情報のみ取得
    ])->pluck('from_user_id');

    $matching_ids = Reaction::whereIn('to_user_id', $got_reaction_ids)
    //$matching_idsにLIKEの人のみの情報を入れる
    ->where('status', Status::LIKE)
    ->where('from_user_id', Auth::id())
    ->pluck('to_user_id');

    // Userテーブルの中からwhereInでLIKEしてくれた人だけを抽出
    $matching_users = User::whereIn('id', $matching_ids)->get();

    $match_users_count = count($matching_users);

    return view('users.index', compact('matching_users', 'match_users_count'));
  }
}
