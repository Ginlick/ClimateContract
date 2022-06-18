<?php
require_once($_SERVER['DOCUMENT_ROOT']."/engines/core.php");
$core = new core;

if (!isset($_GET["file"])){exit;}
$file = $_GET["file"];

if (isset($_GET["name"])){
  $basename = $core->purify($_GET["name"], "quotes");
}
else {
  $basename = $core->purate(preg_match("/[^\/]+$/", $file));
}
$target = dirname($_SERVER['DOCUMENT_ROOT'])."/content/".$file;

if (file_exists($target)){
  if (isset($_GET["count"])){
    $id = $core->purify($_GET["count"], "number");
    $query = "UPDATE contracts SET downloads = downloads + 1 WHERE id = $id";
    $core->conn->query($query);
  }

  header('Content-Type: application/octet-stream');
  header('Content-Disposition: attachment; filename="'.$basename.'"');
  header('Expires: 0');
  header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
  header('Pragma: public');
  header('Content-Length: ' . filesize($target));
  while (ob_get_level()) {
    ob_end_clean();
  }
  readfile($target);
  exit();
}
?>
