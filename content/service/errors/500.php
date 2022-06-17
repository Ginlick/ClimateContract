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
          <h1>500. Server error.</h2>
          <p>Sorry, the server encountered an unexpected condition.</p>
          <a href="/home"><button class="button">Home</button></a>
        </div>
      </section>
    </section>
  </section>
</body>
</html>
<?php echo $core->giveCorelinks(); ?>

<script>

</script>
