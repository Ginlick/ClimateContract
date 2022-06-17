<?php
require_once($_SERVER['DOCUMENT_ROOT']."/engines/core.php");
$core = new core;
if (!isset($_GET["tl"]) || $_GET["tl"] == $core->lang){
  $core->go("/home");
}
if (in_array($_GET["tl"], $core->langs)){
  $core->lang = $_GET["tl"];
} else {echo "ouch"; exit;$core->go("/home");}

setcookie("lang", $core->lang, time()+57820000, "/");

if (isset($_GET["return"])){
  $core->go($_GET["return"]);
}
else {
  $core->go("/home");
}

 ?>﻿
