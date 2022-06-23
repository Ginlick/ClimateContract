<?php
require_once($_SERVER['DOCUMENT_ROOT']."/engines/core.php");
$core = new core(1);

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
          <h1><?php $core->printWord(79); ?></h1>
          <p><?php $core->printText("t-info"); ?></p>
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
