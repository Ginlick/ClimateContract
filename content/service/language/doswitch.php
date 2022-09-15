<?php
require_once($_SERVER['DOCUMENT_ROOT']."/engines/core.php");
$core = new core;
$urllang = $core->lang;

if (!isset($_GET["accept"])){
  $core->acceptCookies();
}

if (!isset($_GET["tl"]) || $_GET["tl"] == $core->lang){
  $core->go("/$urllang/home");
}

if (!$core->switchLang($_GET["tl"])) {
  echo "ouch"; $core->go("/home");
}

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
