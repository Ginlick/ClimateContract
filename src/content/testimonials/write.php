<?php
require_once($_SERVER['DOCUMENT_ROOT']."/engines/core.php");
$core = new core(3);
$core->useContracts();

session_start();
$names = ""; $experience = ""; $selectedContract = 0;
if (isset($_SESSION["testimonial_backup"])){
  if ($backup = json_decode($_SESSION["testimonial_backup"], true)){
    $names = $backup["names"];
    $selectedContract = $backup["contract"];
    $experience = $backup["experience"];
  }
  unset($_SESSION["testimonial_backup"]);
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
          <h1><?php $core->printWord(42); ?></h2>
          <p><?php $core->printWord(43); ?></p>

          <form id="contract-form" action="submit" method="POST">
            <div class="inputCont">
                <label for="names"><?php $core->printWord(44); ?></label>
                <input type="text" name="names" placeholder="<?php $core->printWord(45); ?>" value="<?php echo $names; ?>" autocomplete="off" required/>
                <p class="inputErr"><?php $core->printWord(46); ?></p>
            </div>
            <div class="inputCont">
                <label for="contract"><?php $core->printWord(47); ?></label>
                <select name="contract" required>
                  <?php
                    $list = $core->contracts->giveArr();
                    foreach ($list as $contract){
                      $inset = ""; if ($contract["id"]==$selectedContract){$inset = "selected";}
                      echo "<option value='".$contract["id"]."' $inset>".$contract["name"]."</option>";
                    }
                   ?>
                </select>
                <p class="inputErr"><?php $core->printWord(48); ?></p>
            </div>
            <div class="inputCont">
                <label for="experience"><?php $core->printWord(49); ?></label>
                <textarea name="experience" rows="9" placeholder="<?php $core->printWord(50); ?>" required><?php echo $experience; ?></textarea>
                <p class="inputErr"><?php $core->printWord(51); ?></p>
            </div>
            <p class="errorBoi" id="errorBoi"></p>
            <button class="button g-recaptcha"
                data-sitekey="6LcM9oQgAAAAACRMSlbT3orTJqwTEZntr-HIHk7P"
                data-callback='onSubmit'
                data-action='submit'><?php $core->printWord(52); ?></button>
              <a href="../../testimonials"><button class="button grey" type="button"><?php $core->printWord(56); ?></button></a>
          <script src="https://www.google.com/recaptcha/api.js"
              async defer>
          </script>
          </form>
        </div>
      </section>
    </section>
  </section>
  <?php echo $core->giveFooter(); ?>
</body>
</html>
<?php echo $core->giveCorelinks(); ?>
<script>
var urlParams = new URLSearchParams(window.location.search);
var error = urlParams.get('e');
var errorBoi = document.getElementById("errorBoi");
if (error == "fraud"){
  errorBoi.style.display="block";
  errorBoi.innerHTML = "<?php $core->printWord(53); ?>";
}
else if (error == "badinput"){
  errorBoi.style.display="block";
  errorBoi.innerHTML = "<?php $core->printWord(54); ?>";
}
else if (error == "error"){
  errorBoi.style.display="block";
  errorBoi.innerHTML = "<?php $core->printWord(55); ?>";
}



  function onSubmit(token) {
    document.getElementById("contract-form").submit();
  }

for (let inputCont of document.getElementsByClassName("inputCont")) {
    let input = inputCont.children[1];
    if (inputCont.children[2] != undefined){
      input.addEventListener("focus", showInfo);
      input.addEventListener("focusout", hideInfo);
    }
}
function showInfo(evt) {
  if (evt.currentTarget.parentElement.children[2] != undefined){
    evt.currentTarget.parentElement.children[2].style.opacity = "1";
  }
}
function hideInfo(evt) {
    evt.currentTarget.parentElement.children[2].style.opacity = "0";
}
</script>
