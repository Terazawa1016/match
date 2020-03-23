<?php

namespace App\Constant;

class Status
{

  // Reactionモデルではstatusをintegerで指定しているため、数字が入るようにしている
  //ここでは数字だけではLIKEかDISLIKEかわからない為、ここで設定
  const LIKE = 0;
  const DISLIKE = 1;
}
