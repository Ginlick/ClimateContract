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
        padding: 60px 0;
        display: flex;
        align-items: center;
        position: relative;
      }
      .homeBanner .leftone {
        z-index: 1;
        width: 60%;
        height: 100%;
        display: flex;
        flex-direction: column;
        text-align: left;
        }
        .subtitle {
          font-weight: lighter;
        }
        .backimg {
          position: absolute;
          width: 40%;
          height: 100%;
          object-fit: cover;
          top: 0;
          right: 0;
        }

        .timeline {
          line-height: 1.3em;
          list-style-type: none;
          margin: 0; padding: 0;
          width: 100%;
        }
        .timeline-item {
          padding: 10px 0 20px 70px;
          position: relative;
        }
        .timeline-bar {
          position: absolute;
          top: 15px;
          bottom: 0;
          left: 15px;
          width: 15px;
        }
        .timeline-bar::before {
          background: var(--accent);
          border: 4px solid transparent;
          border-radius: 100%;
          content: "";
          display: block;
          height: 20px;
          position: absolute;
          top: -5px;
          left: -7px;
          width: 20px;
          transition: background 0.3s ease-in-out,border 0.3s ease-in-out;
        }
        .timeline-bar::after {
          content: "";
          width: 3px;
          background: var(--accent);
          display: block;
          position: absolute;
          top: 0;
          bottom: -15px;
          left: 6px;
        }
        .timeline h3 {
          margin: 0 0 15px;
        }
        .timeline p {
          margin: 0 0 10px;
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
      <section class="textColumn-cont">
        <div class="homeBanner">
          <div class="leftone">
            <h2 class="homeBuptitle margin-bottom-0"><span class="greenText">Green</span> Youth Contract</h2>
            <h2 class="subtitle margin-top-0"><?php $core->printWord(5); ?></h2>
          </div>
        </div>
        <img class="backimg" src="/visuals/worldshake.jpeg" alt="world handshake" />
      </section>
      <section class="textColumn-cont">
        <div class="textColumn">
          <p><?php $core->printWord(6); ?></p>
          <p><?php $core->printWord(7); ?></p>
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
</body>
</html>
<?php echo $core->giveCorelinks(); ?>

<script>

</script>
