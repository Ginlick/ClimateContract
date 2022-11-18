<?php
require_once($_SERVER['DOCUMENT_ROOT']."/engines/core.php");
$core = new core;
$core->useAccounts();
$core->acceptCookies();

$reminder=false;$newsletter=false;
if (isset($_POST["reminder"])){$reminder = true;}
if (isset($_POST["newsletter"])){$newsletter = true;}
if (isset($_POST["email"]) AND preg_match("/^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i", $_POST["email"])==1){$email = $_POST["email"];} else if (!$core->accounts->loggedIn) {echo "failed"; exit;} else {$email = $core->accounts->loggedIn["email"];}
if (isset($_POST["popup"]) AND $_POST["popup"] == "on"){$popup = true;} else {$popup=false;}

if ($core->accounts->check($email)){
  if ($acc = $core->accounts->loggedIn){
    $settings = $acc["settings"];
    if (!isset($settings["reminder"]) OR $settings["reminder"] == NULL){$settings["reminder"] = [];}
    if ($reminder == true){array_push($settings["reminder"], time()+5256000);}
    if ($newsletter == true){$settings["newsletter"]=1;}
    $settings = json_encode($settings);

    $query = "UPDATE accounts SET settings = '$settings' WHERE id = ".$acc["id"];
    //echo $query;
    if ($core->conn->query($query)){
      if ($popup){
        setcookie("showCDlPopup", "0", time()+15725000, "/");
      }
      echo "success"; exit;
    }
  }
}

echo "failed";


 ?>﻿
