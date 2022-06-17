<?php
  require_once($_SERVER['DOCUMENT_ROOT']."/engines/core.php");
  $core = new core;
  if (!isset($_GET["tl"]) || $_GET["tl"] == $core->lang){
    $core->go("/home");
  }
  if (in_array($_GET["tl"], $core->langs)){
    $core->lang = $_GET["tl"];
  } else {echo "ouch"; exit;$core->go("/home");}

if (isset($_GET["return"])){
  $return = $core->purate($_GET["return"], "quotes");
}
else {
  $return = "/home";
}

if (isset($_COOKIE["lang"])){
  $core->go("doswitch?tl=".$core->lang."&return=".$return);
}

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
          <h1><?php $core->printWord(28); ?></h2>
          <p><?php $core->printWord(29); ?></p>
          <a href="doswitch?tl=<?php echo $core->lang."&return=".$return; ?>"><button class="button"><?php $core->printWord(30); ?></button></a>
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
