<?php
require_once($_SERVER['DOCUMENT_ROOT']."/engines/core.php");
$core = new core;
$urllang = strtolower($core->lang);

if (!isset($_GET["tl"]) || $_GET["tl"] == $core->lang){
  $core->go("/$urllang/home");
}
if (in_array($_GET["tl"], $core->langs)){
  $core->lang = $_GET["tl"];
} else {echo "ouch"; exit;$core->go("/home");}

setcookie("lang", $core->lang, time()+57820000, "/");
$urllang = strtolower($core->lang);

if (isset($_GET["return"])){
  $return = preg_replace("/^\/[A-Za-z]{2}\//", "/", $_GET["return"]);
  $return = "/".$urllang.$return;
  $core->go($return);
}
else {
  $core->go("/.$urllang./home");
}

 ?>﻿
