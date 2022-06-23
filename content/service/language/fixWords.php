<?php
function doWords($file){
  $strJsonFileContents = file_get_contents($_SERVER['DOCUMENT_ROOT'].$file);
  $wordArr = json_decode(preg_replace('/[\x00-\x1F]/', '', $strJsonFileContents), true, 512, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

  $finalArr = [];

  if(array_keys($wordArr) !== range(0, count($wordArr) - 1)) {
    return;
  }
  else {
    foreach ($wordArr as $word) {
      $finalArr[$word["id"]] = $word;
    }
  }

  $finalArr = json_encode($finalArr, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
  //$finalArr = json_decode($finalArr, true);
  if (file_put_contents($_SERVER['DOCUMENT_ROOT'].$file, $finalArr)){
    echo "did $file";
  }
}
doWords("/service/language/words.json");
doWords("/service/language/text.json");

 ?>﻿
