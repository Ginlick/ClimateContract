<?php
  require_once($_SERVER['DOCUMENT_ROOT']."/engines/core.php");
  $core = new core(1);
 ?>﻿

<!DOCTYPE html>
<html>
<head>
    <?php echo $core->giveHtmlHeaders(); ?>
    <style>

      .homeBanner {
        width: var(--largecontentcolumn-width);
        margin: auto;
        display: flex;
        align-items: center;
        position: relative;
      }
      .leftone {
        z-index: 1;
        width: 60%;
        height: 100%;
        padding: 110px 0;
        box-shadow: -30px 0 22px 60px var(--bg);
        display: flex;
        flex-direction: column;
        text-align: left;
        background-color: var(--bg);
        transition: 0.5s;
        }
        .leftone:hover {
          transform: translateX(3%);

        }
        .subtitle {
          font-weight: lighter;
        }
        .backimg {
          position: absolute;
          width: 60%;
          height: 100%;
          object-fit: cover;
          top: 0;
          right: 0;
        }

        .midBar-cont {
          background-color: var(--accent);
          width: 100%;
        }
        .midBar {
          width: var(--largecontentcolumn-width);
          margin: auto;
          display: flex;
          flex-direction: row;
          align-items: space-evenly;
          color: var(--bg);
        }

    </style>
</head>
<body>
  <section class="allcontent">
          <?php echo $core->giveHeader(); ?>
    </header>
    <section class="maincontent">
      <section class="textColumn-cont nopad" >
        <img class="backimg" src="/visuals/worldglobe.jpg" alt="world handshake" />
        <div class="homeBanner">
          <div class="leftone">
            <h2 class="homeBuptitle margin-bottom-0 greyText">Climate Contract</h2>
            <h2 class="subtitle margin-top-0"><?php $core->printWord(5); ?></h2>
          </div>
        </div>
      </section>
      <section class="textColumn-cont">
        <div class="textColumn">
          <p><?php $core->printWord(6, true); ?></p>
          <a href="/contracts"><button class="button"><?php $core->printWord("7b"); ?></button></a>
        </div>

        <div class="midBar-cont">
          <div class="midBar">
            <h1><?php $core->printWord(10); ?></h1>
          </div>
        </div>

        <div class="textColumn">
          <h2><?php $core->printWord(11); ?></h2>
          <ul class="timeline">
            <li class="timeline-item">
              <div class="timeline-content">
                <h3><?php $core->printWord(13); ?></h3>
                <p><?php $core->printWord(16); ?></p>
              </div>
              <div class="timeline-bar"></div>
            </li>
            <li class="timeline-item">
              <div class="timeline-content">
                <h3><?php $core->printWord(14); ?></h3>
                <p><?php $core->printWord(17); ?></p>
              </div>
              <div class="timeline-bar"></div>
            </li>
            <li class="timeline-item">
              <div class="timeline-content">
                <h3><?php $core->printWord(15); ?></h3>
                <p><?php $core->printWord(18); ?></p>
              </div>
              <div class="timeline-bar"></div>
            </li>
          </ul>

          <h2><?php $core->printWord(12); ?></h2>
          <p><?php $core->printWord(19); ?></p>
        </div>
      </section>
    </section>
  </section>
  <?php echo $core->giveFooter(); ?>

  <?php
    echo $core->givePopup($core->giveText("t-pop-test"), "testphase");
   ?>
</body>
</html>
<?php echo $core->giveCorelinks(); ?>

<script>
var urlParams = new URLSearchParams(window.location.search);

if (!localStorage["alertdisplayed"] || urlParams.get('test') !== null) {
  togglePop("testphase");
  localStorage["alertdisplayed"] = true;
}
</script>
