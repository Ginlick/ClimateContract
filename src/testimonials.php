<?php
require_once($_SERVER['DOCUMENT_ROOT']."/engines/core.php");
$core = new core(3);
$blog = $core->useBlogs();

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
          <h1><?php $core->printWord(39); ?></h1>
          <p><?php $core->printWord(40); ?></p>
          <a href="content/testimonials/write"><button class="button"><?php $core->printWord(41); ?></button></a>
          <p><?php $core->printWord(107, true); ?></p>
        </div>
        <div class="textColumn">
          <?php echo $blog->genSortCont("explore-feed"); ?>
          <section class="feed"  blog-feed blog-feed-settings='{"explore":1}' id="explore-feed">
          </section>
        </div>
      </section>
    </section>
  </section>
  <?php echo $core->giveFooter(); ?>
</body>
</html>
<?php echo $core->giveCorelinks(); ?>
<script>
var urlParams = new URLSearchParams(window.location.search);
var notif = urlParams.get('i');
if (notif == "notfound"){

}
</script>
