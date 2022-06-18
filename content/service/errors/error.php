<?php
  require_once($_SERVER['DOCUMENT_ROOT']."/engines/core.php");
  $core = new core;

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
    </header>
    <section class="maincontent">
      <section class="textColumn-cont">
        <div class="textColumn">
          <h1><?php $core->printWord(34); ?></h2>
          <p><?php $core->printWord(35); ?></p>
          <a href="/home"><button class="button"><?php $core->printWord(33); ?></button></a>
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
