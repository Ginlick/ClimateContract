<?php
require($_SERVER['DOCUMENT_ROOT']."/engines/core.php");
$core = new core;
$blog = $core->useBlogs();

$mode = "new";
if (isset($_POST["m"])){$mode = preg_replace("/[^a-z]/", "", $_POST['m']);}
$offset = 0;  $settings = [];
if (isset($_POST["o"])){$offset = preg_replace("/[^0-9]/", "", $_POST['o']);}
if (isset($_POST["s"])){$settings = $blog->getArray($_POST["s"]);}

$hasWhere = true;
$query = "SELECT * FROM testimonials WHERE language = '".$core->lang."'";


if ($mode == "likes"){
  $query .= " ORDER BY likes DESC";
}
else if ($mode == "random") {
  $query .= " ORDER BY RAND()";
}
else if ($mode == "old"){
  $query .= " ORDER BY reg_date ASC";
}
else {
  $query .= " ORDER BY reg_date DESC";
}

if ($mode == "random"){
  $query .= " LIMIT 8";
}
else {
  $query .= " LIMIT $offset, 8";
}

//echo $query;
//echo $query; exit;

$total = 0;
if ($toprow = $blog->conn->query($query)) {
  if (mysqli_num_rows($toprow)==0){echo "No more posts."; exit;}
  while ($row = $toprow->fetch_assoc()) {
    $explore = false; if (isset($settings["explore"])){$explore = true;}
    echo $blog->genPost($row, 0, $explore);
  }
}

?>
