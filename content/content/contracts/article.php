<?php
require_once($_SERVER['DOCUMENT_ROOT']."/engines/core.php");
$core = new core(2);
$core->useContracts();

$articleQ = $_GET["id"];
$contractId = 0;
if (preg_match("/^[0-9]+/", $articleQ, $matches)) {
  $contractId = $matches[0];
}
$contract = $core->contracts->giveArr($contractId, true);
$articleId = $contract["articleLink"];

$articleText = $core->giveText($articleId, "article");
if (!$articleText){
  $core->go(404);
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
    <section class="maincontent">
      <section class="textColumn-cont">
        <div class="textColumn">
          <div class="titleBlock">
            <a class="backA greylink" href="/content/contracts/info"><i class="fa-solid fa-arrow-left"></i> <?php $core->printWord(91); ?></a>

            <h1><?php echo $contract["name"]; ?></h1>
            <span class="info italiced"><?php $core->printWord(92); ?></span><br>
          </div>
          <p>
            <?php echo $articleText; ?>
          </p>
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
