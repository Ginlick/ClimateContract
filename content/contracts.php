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
      .contract-box {
        width: 100%;
        border: 1px solid var(--border-color);
        border-radius: 5px;
        overflow: hidden;
        position: relative;
        padding: 8px;
        display: flex;
        margin: 3em 0;
        box-sizing: border-box;
      }
      .contract-thumbnail {
        width: 15%;
      }
      .squareCont {
        width: 100%;
        position: relative;
        overflow: hidden;
      }
      .squareCont::after {
        content: "";
        display: block;
        padding-bottom: 100%;
      }
      .square {
        position: absolute;
        height: 100%;
        width: 100%;
        overflow: hidden;
        border-radius: 5px;
      }
      .square img {
        width: 100%; height: 100%;
        object-fit: cover;
      }

      .contractCont {
        width: 70%;
        padding: 0 5px 0 12px;
      }
      .contractCont p {
        margin-bottom: 0.3em;
      }
      .main-contract-title {
        color: var(--main);
      }
      .buttCont {
        align-self: flex-start;
        display: flex;
        flex-direction: column;
      }

    </style>
</head>
<body>
  <section class="allcontent">
    <?php echo $core->giveHeader(); ?>
    <section class="maincontent">
      <section class="textColumn-cont">
        <div class="textColumn">
          <h1><?php $core->printWord(26); ?></h2>
          <p class="big-margin-bottom"><?php $core->printWord(27); ?></p>
          <?php
            echo $core->contracts->giveAll();
          ?>
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
