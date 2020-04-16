<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Services\CheckExtensionServices;
use App\Services\FileUploadServices;

use Intervention\Image\Facades\Image;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'img_name' => ['file', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2000'],
            'self_introduction' => ['string', 'max:255'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
     protected function create(array $data)
      {

        //まずここでバリデーションを逃れた画像を取得する
        $imageFile = $data['img_name'];
        //引数$dataからname='img_name'を取得(アップロードするファイル情報)
        $list = FileUploadServices::fileUpload($imageFile);

        //$imageFileからファイル名を取得(拡張子あり)
        list($extension, $fileNameToStore, $fileData) = $list;

        //拡張子ごとにbase64エンコード実施
        $data_url = CheckExtensionServices::checkExtension($fileData, $extension);

        //画像アップロード(imageクラス makeメソッドを使用)
        $image = Image::make($data_url);

        //画像を横400px, 縦400pxにリサイズして保存
        $image->resize(400,400)->save(storage_path() . '/app/public/images/' . $fileNameToStore );

        //createメソッドでユーザー情報を作成
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'self_introduction' => $data['self_introduction'],
            'sex' => $data['sex'],
            'img_name' => $fileNameToStore,
        ]);
      }
  }
