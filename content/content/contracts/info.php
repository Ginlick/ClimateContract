<?php
require_once($_SERVER['DOCUMENT_ROOT']."/engines/core.php");
$core = new core(2);
$core->useContracts();


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
          <div class="titleBlock">
            <a class="backA greylink" href="/contracts#offer"><i class="fa-solid fa-arrow-left"></i> <?php $core->printWord(91); ?></a>

            <h1><?php $core->printWord("95"); ?></h1>
          </div>
          <?php  $core->printText("t-cinfo"); ?>
          <ul class="timeline">
            <?php echo $core->contracts->giveAll("articles"); ?>
          </ul>
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
