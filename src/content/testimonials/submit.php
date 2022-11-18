<?php
require_once($_SERVER['DOCUMENT_ROOT']."/engines/core.php");
$core = new core(3);
$core->useContracts();
$captcha_skey = $core->getskey("captcha");

session_start();
$_SESSION["testimonial_backup"] = json_encode($_POST);
print_r($_POST);

//get reCAPTCHA score
$url = 'https://www.google.com/recaptcha/api/siteverify';
$data = array('secret' => $captcha_skey, 'response' => $_POST["g-recaptcha-response"], "remoteip"=>$_SERVER['REMOTE_ADDR']);
$options = array(
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data)
    )
);
$context  = stream_context_create($options);
$result = json_decode(file_get_contents($url, false, $context), true);

if (!$result["success"] OR !isset($result["score"]) OR $result["score"] < 0.5){
  $core->go("write?e=fraud");
}


//do the actual thing
if (!isset($_POST["names"]) OR !isset($_POST["contract"]) OR !isset($_POST["experience"])){
  $core->go("write?e=badinput");
}
$names = addslashes($core->purify(substr($_POST["names"], 0, 99), "dicWord"));
$contract = $core->purify($_POST["contract"], "number");
if (!isset($core->contracts->giveArr()[$contract])){$core->go("write?e=badinput");}
$experience = addslashes(substr($_POST["experience"], 0, 2222));

$query = "INSERT INTO testimonials (contract, language, names, experience) VALUES ('$contract', '$core->lang', '$names', '$experience')";
if ($core->conn->query($query)){
  unset($_SESSION["testimonial_backup"]);
  $core->go("/testimonials");
}
else {
  $core->go("write?e=error");
}

 ?>﻿
