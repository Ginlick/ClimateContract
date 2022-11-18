<?php
require_once($_SERVER['DOCUMENT_ROOT']."/engines/core.php");
$core = new core;

if (isset($_POST["reminder"]) AND $_POST["reminder"] == "on"){$reminder = true;} else {$reminder=false;}
if (isset($_POST["newsletter"]) AND $_POST["newsletter"] == "on"){$newsletter = true;} else {$reminder=false;}
if (isset($_POST["email"]) AND preg_match("/^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i", $_POST["email"])==1){$email = $_POST["email"];} else {echo "false"; exit;}
if (isset($_POST["popup"]) AND $_POST["popup"] == "on"){$popup = true;} else {$popup=false;}



 ?>﻿
