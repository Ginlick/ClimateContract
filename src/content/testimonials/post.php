<?php
require_once($_SERVER['DOCUMENT_ROOT']."/engines/core.php");
$core = new core(3);
$blog = $core->useBlogs();

if (isset($_GET["id"])){$postId = $core->purify($_GET['id'], "number");}else {$core->go("/testimonials?i=notfound");}
$notfound = true;
$query = "SELECT * FROM testimonials WHERE id = '$postId'";
if ($toprow = $blog->conn->query($query)) {
  if (mysqli_num_rows($toprow) == 1) {
    while ($row = $toprow->fetch_assoc()) {
      $notfound = false;
      $pRow = $row;
      $pParsed = $blog->genPost($pRow, 1);
      $pNames = $row["names"];
    }
  }
}
if ($notfound) {$core->go("/testimonials?i=notfound");}
 ?>﻿

<!DOCTYPE html>
<html>
<head>
    <?php echo $core->giveHtmlHeaders(); ?>
    <style>

    </style>
</head>
<body>
  <section class="allcontent">
    <?php echo $core->giveHeader(); ?>
    <section class="maincontent">
      <section class="textColumn-cont">
        <div class="textColumn">
          <h1><?php echo $core->giveWord(75)." ".$pNames; ?></h1>
          <?php echo $pParsed; ?>
          <p><a href="/testimonials"><?php $core->printWord(77); ?></a></p>
          <p><?php $core->printWord(76); ?></p>
          <a href="/content/testimonials/write"><button class="button"><?php $core->printWord(41); ?></button></a>
        </div>
      </section>
    </section>
  </section>
  <?php echo $core->giveFooter(); ?>
</body>
</html>
<?php echo $core->giveCorelinks(); ?>
<script>

</script>
