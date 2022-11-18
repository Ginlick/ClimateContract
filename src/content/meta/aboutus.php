<?php
require_once($_SERVER['DOCUMENT_ROOT']."/engines/core.php");
$core = new core();

 ?>﻿

<!DOCTYPE html>
<html>
<head>
    <?php echo $core->giveHtmlHeaders(); ?>
    <style>
      .profiles-container {
        display: flex;
      }
      .profile-block {
        margin: 20px;
        padding: 10px;
        width: calc(50% - 40px);
        border-radius: 5px;
      }
      .profile-image {
        padding: 5px;
      }
      .profile-image-block {
        width: 86%;
        margin: 20px auto 40px;
        position: relative;
        overflow: hidden;
      }
      .profile-image-block::after {
        content: "";
        display: block;
        padding-bottom: 100%;
      }
      .profile-image {
        position: absolute; height: 100%;width: 100%;
        overflow: hidden;
        object-fit: cover;
        border-radius: 600px;
        border: 10px solid var(--accent);
        padding: 0;
      }
      .profile-text p {
        font-size: var(--small-font-size);
      }

    </style>
</head>
<body>
  <section class="allcontent">
    <?php echo $core->giveHeader(); ?>
    <section class="maincontent">
      <section class="textColumn-cont">
        <div class="textColumn">
          <h1><?php $core->printWord(104); ?></h1>
          <p><?php $core->printWord(105); ?></p>
          <section class="profiles-container">
            <div class="profile-block">
              <div class="profile-image-block">
                <img class="profile-image" src="/visuals/illusts/Simon.png" alt="Simon">
              </div>
              <div class="profile-text">
                <?php $core->printWord("desc-simon", true); ?>
              </div>
            </div>
            <div class="profile-block">
              <div class="profile-image-block">
                <img class="profile-image" src="/visuals/illusts/blankp.webp" alt="Monja">
              </div>
              <div class="profile-text">
                <?php $core->printWord("desc-monja", true); ?>
              </div>
            </div>
          </section>
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
