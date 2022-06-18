<?php
$strJsonFileContents = file_get_contents($_SERVER['DOCUMENT_ROOT']."/service/language/words.json");
$wordArr = json_decode(preg_replace('/[\x00-\x1F]/', '', $strJsonFileContents), true, 512, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

$finalArr = [];

if(array_keys($wordArr) !== range(0, count($wordArr) - 1)) {
  $finalArr = $wordArr;
}
else {
  echo "work to do";
  foreach ($wordArr as $word) {
    $finalArr[$word["id"]] = $word;
  }
}

$finalArr = json_encode($finalArr, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
//$finalArr = json_decode($finalArr, true);
file_put_contents($_SERVER['DOCUMENT_ROOT']."/service/language/words.json", $finalArr);
print_r($finalArr);
 ?>﻿
