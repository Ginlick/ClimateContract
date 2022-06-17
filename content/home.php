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
        padding-left: 3em;
        text-align: left;
        }
        .homeBuptitle {
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
            <h2 class="subtitle margin-top-0">Easily encourage sustainability.</h2>
          </div>
        </div>
        <img class="backimg" src="/visuals/worldshake.jpeg" alt="world handshake" />
      </section>
      <section class="textColumn-cont">
        <div class="textColumn">
          <p>Parents and their children sign a contract guaranteeing financial support for the extra costs of sustainable behavior. In this way, the biggest hindrance to climate-friendly life is removed.</p>
          <p><a href="/contracts">Download a contract</a> today!</p>
        </div>
      </section>
    </section>
  </section>
</body>
</html>
<?php echo $core->giveCorelinks(); ?>

<script>

</script>
