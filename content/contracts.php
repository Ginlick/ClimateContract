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

    .upperpart {
      height: calc(100vh - var(--header-height));
      background: var(--bg) url("/visuals/globe2.jpg") no-repeat left top scroll;
      background-size: cover;
      position: relative;
      display: flex;
      justify-content: space-evenly;
    }

    .bigcircle {
      width: min(max(80%, 1000px), 1300px);
      margin: auto;

      position: absolute;
      top:0;
      overflow: hidden;

    }
    .bigcircle::after {
      content: "";
      display: block;
      padding-bottom: 100%;
    }
    .inner {
      position: absolute;
      height: 100%;
      width: 100%;
      overflow: hidden;

      border-radius: 50%;
      background-color: var(--bg-trans);
      padding: 30% 0 15px;
      transform: translateY(-30%);
      transition: .5s;

      display: flex;
      justify-content: space-evenly;
    }
    .inner:hover {
      background-color: var(--bg);
    }
    .incircle {
      width: min(80%, 80vw);
    }
    .downloadercont {
      padding: 40px 0;
    }
    .dlButtonCont {
      padding: 15px;
    }
    .downloadercont a {
      color: var(--border-color);
    }
    .downloadercont a:hover {
      color: var(--link-hover);
    }

    </style>
</head>
<body>
  <section class="allcontent">
    <?php echo $core->giveHeader(); ?>
      <section class="upperpart">
        <section class="bigcircle">
          <div class="inner centered">
            <div class="incircle">
              <h1><?php $core->printWord(86); ?></h2>
              <p><?php $core->printWord(87); ?></p>
              <div class="downloadercont">
                <?php
                  echo $core->contracts->giveMain();
                ?>
              </div>
            </div>


          </div>
        </section>
      </section>
      <section class="textColumn">
        <h2><?php $core->printWord(88); ?></h2>
        <p class="big-margin-bottom"><?php $core->printWord(27); ?></p>
        <?php
          echo $core->contracts->giveAll();
        ?>
      </section

    </section>
  <?php echo $core->giveFooter(); ?>
</body>
</html>
<?php echo $core->giveCorelinks(); ?>

<script>

</script>
