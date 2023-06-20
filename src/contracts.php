<?php
require_once($_SERVER['DOCUMENT_ROOT']."/engines/core.php");
$core = new core(2);
$core->useContracts();
$core->useAccounts();
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
      overflow: hidden;
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
              <p><a href="#offer"><?php $core->printWord(90); ?></a></p>
            </div>


          </div>
        </section>
      </section>
      <section class="textColumn" id="offer">
        <h2><?php $core->printWord(88); ?></h2>
        <p class="big-margin-bottom"><?php $core->printWord(27); ?></p>
        <?php
          echo $core->contracts->giveAll();
        ?>
      </section>
    </section>

    <?php
      $submittable = false;
      if (!$core->accounts->loggedIn OR !isset($core->accounts->loggedIn["settings"]["newsletter"]) OR $core->accounts->loggedIn["settings"]["newsletter"]!=1){
        $email = "";
        if ($core->accounts->loggedIn){$email = $core->accounts->loggedIn["email"];}

        $text = '
        <h2>'.$core->giveWord(97).'</h2>
        <form id="cDownloadedForm">'.
          $core->giveText("t-pop-cdl").$core->giveText("t-pop-cdln").'
          <input oninput="checkCDownloadedForm(this);" style="margin-top: 10px" type="text" name="email" value="'.$email.'" placeholder="john.doe@hello.world"></input>
          <p>'.$core->giveCookieDisclaimer(1).'</p>
          <div class="block-button">
            <button type="button" class="button grey" onclick=\'togglePop("cDownloaded")\'><i class="fa-solid fa-times"></i> '.$core->giveWord(98).'</button><button type="button" id="cDlFormButt" class="button dead" onclick="cDownloadedSubmit();">'.$core->giveWord(99).'</button>
          </div>
          <div class="fakep"><input type="checkbox" name="popup"></input><label>'.$core->giveWord(101).'</label></div>
        </form>
        ';
      }
      else {
        $submittable = true;
        $text = '
        <h2>'.$core->giveWord(97).'</h2>
        <form id="cDownloadedForm">'.
          $core->giveText("t-pop-cdl").'
          <p>'.$core->giveCookieDisclaimer(2).'</p>
          <div class="block-button">
            <button type="button" class="button grey" onclick=\'togglePop("cDownloaded")\'><i class="fa-solid fa-times"></i> '.$core->giveWord(98).'</button><button type="button" id="cDlFormButt" class="button" onclick="cDownloadedSubmit();">'.$core->giveWord(100).'</button>
          </div>
        <div class="fakep"><input type="checkbox" name="popup"></input><label>'.$core->giveWord(101).'</label></div>
        </form>
        ';
      }

          echo $core->givePopup($text, "cDownloaded");
        ?>


  <?php echo $core->giveFooter(); ?>
</body>
</html>
<?php echo $core->giveCorelinks(); ?>

<script>
var submittable = false;
<?php if ($submittable){echo "submittable = true;";} ?>

function downloadedC(articleLink) {
  if (document.cookie.indexOf('showCDlPopup') == -1){
    gimmeInfoLink = document.getElementById("gimmeInfolink");
    if (gimmeInfoLink != null){gimmeInfoLink.setAttribute("href", articleLink);}
    togglePop("cDownloaded");
  }
}
function checkCDownloadedForm(emailInput) {
  reg =  /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
  if (emailInput.value.toLowerCase().match(reg)){
    submittable = true;
    document.getElementById("cDlFormButt").classList.remove("dead");
    emailInput.value = emailInput.value.toLowerCase();
  }
  else {
    submittable = false;
    document.getElementById("cDlFormButt").classList.add("dead");
  }
}
function cDownloadedSubmit() {
  if (!submittable){return;}
  var form = document.getElementById("cDownloadedForm");
  var formData = new FormData();
  for (let element of form.elements){
    if (element.getAttribute('type') === 'checkbox' && !element.checked){continue;}
    formData.append(element.getAttribute("name"), element.value);
  }
  console.log(formData);

  portal = "/service/account/cdlform.php";
  var xhttp = new XMLHttpRequest();

  xhttp.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
          let result = xhttp.responseText;
          console.log(result);
          if (result.includes("success")){
            form.reset();
            togglePop("cDownloaded");
          }
      }
  };
  xhttp.open("POST", portal, true);
  xhttp.send(formData);
}

</script>
