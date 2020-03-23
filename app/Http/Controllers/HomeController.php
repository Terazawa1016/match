<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
      // ここで認証済みであれば表示、認証されなかったら/loginにリダイレクト
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {
      // Userテーブルの情報を全て取得
      $users = User::all();

      $userCount = $users->count()-1;

      //現在ログインしているユーザーのIDを取得
      $from_user_id = Auth::id();

      // $users('users')をviewに渡してあげる
        return view('home', compact('users', 'userCount', 'from_user_id'));
    }
}
