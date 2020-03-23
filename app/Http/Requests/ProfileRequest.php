<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Auth;

class ProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
      // Auth::user()->emailとすることでログイン済みユーザのアドレス取得
      $myEmail = Auth::user()->email;

      return [
        // バリデーションルールを記述
        'name' => 'required|string|max:255',
        // こっちはmailの内容のルール
        'email' => ['required',
                    'string',
                    'email',
                    'max:255',
                // whereNotでログイン済みユーザのアドレスは除外してる
                Rule::unique('users', 'email')->whereNot('email', $myEmail)],
      ];
    }
}
