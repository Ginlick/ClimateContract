<?php
$strJsonFileContents = file_get_contents($_SERVER['DOCUMENT_ROOT']."/service/language/words.json");
$wordArr = json_decode(preg_replace('/[\x00-\x1F]/', '', $strJsonFileContents), true, 512, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

$finalArr = [];

foreach ($wordArr as $word) {
  $finalArr[$word["id"]] = $word;
}
$finalArr = json_encode($finalArr, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
$finalArr = json_decode($finalArr, true);
$finalArr = json_encode($finalArr);
//$finalArr = json_decode($finalArr, true);
print_r($finalArr);
 ?>﻿
