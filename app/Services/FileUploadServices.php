<?php

namespace App\Services;

class FileUploadServices
{
  public static function fileUpload($imageFile){

    //$imageFileからファイル名を取得(拡張子あり)
    $fileNameWithExt = $imageFile->getClientOriginalName();

    //拡張子を除いたファイルを取得
    $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);

    //拡張子を取得
    $extension = $imageFile->getClientOriginalExtension();

    //ファイル名_時間_拡張子として名前づけ
    $fileNameToStore = $fileName.'_'.time().'.'.$extension;

    //画像ファイル取得
    $fileData = file_get_contents($imageFile->getRealPath());

    $list = [$extension, $fileNameToStore, $fileData];

    //ここで返す値を一つしかできないので上の$list変数を配列にして返す
    return $list;
  }
}
