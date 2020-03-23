<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Intervention\Image\Facades\Image;
use App\Services\FileUploadServices;
use App\Services\CheckExtensionServices;
use App\Http\Requests\ProfileRequest;

class UserController extends Controller
{

  //$idとすることでurlにshow/1とすることでUserテーブルの情報を取得できる
  public function show($id)
  {
    //User::findorFailでUserテーブルの指定のidがあれば取得する
    $user = User::findorFail($id);
    // dd($user);
    //ここで$user変数の値をviewにcompact関数で送ってやる
    return view('users.show', compact('user'));
  }

  //編集ページを呼び出す
  public function edit($id)
  {
    $user = User::findorFail($id);

    return view('users.edit', compact('user'));
  }

  //編集後の処理をする
  //引数のProfileRequestで名前とメールのチェック
  public function update($id, ProfileRequest $request)
  {

    $user = User::findorFail($id);

    // is_nullで変数かどうか調べる。ここではimag_nameがnullでなかったら、となる
    if(!is_null($request['img_name'])){

      // 変数にアップロード画像を入れる
      $imageFile = $request['img_name'];

      $list = FileUploadServices::fileUpload($imageFile);

      //listは複数の変数への代入を行う
      // 🟡代入しているのは$list変数をlist()の中の変数一つ一つ❓
      list($extension, $fileNameToStore, $fileData) = $list;

      //ここでチェックした後の変数を取得
      $data_url = CheckExtensionServices::checkExtension($fileData, $extension);

      // image画像を取得し、変数化
      $image = Image::make($data_url);
      // 取得した画像をリサイズ
      $image->resize(400,400)->save(storage_path().'/app/public/images/'. $fileNameToStore);

      $user->img_name = $fileNameToStore;
    }

    // ここでフォームに入力された値を$userに入れている
    //$request->nameと書くと、フォームに入力されているユーザ名が取得できる
    //以下同じ
    $user->name = $request->name;
    $user->email = $request->email;
    $user->sex = $request->sex;
    $user->self_introduction = $request->self_introduction;

    // 全ての情報を$userに入れて$user->save()で保存
    $user->save();

    return redirect()->to('home');
  }
}
