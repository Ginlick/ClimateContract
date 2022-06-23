<?php

class blogEngine {
    public $conn;

    function __construct($core){
      $this->core = $core;
      $this->conn = $core->conn;
    }

    //functionality
    function getArray($arr) {
      $followers = [];
      $arr = preg_replace('/[\r]/', '\n', $arr);
      $arr = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $arr);
      $arr = str_replace("u0027", "'", $arr);
      $arr = json_decode($arr, true, 22, JSON_INVALID_UTF8_SUBSTITUTE);
      if (gettype($arr)=="array"){
        foreach ($arr as $k=>$value) {
          $arr[$k]=utf8_decode($value);
        }
        $followers = $arr;
      }
      return $followers;
    }
    function getCommaArr($arr, $reg = "full", $limit = 22) {
      $pgenre = explode(", ", $arr);
      $pgenre = array_slice($pgenre, 0, $limit);
      foreach ($pgenre as $key => &$tag) {
        $tag = $this->core->purify($tag, $reg);
        if ($tag == ""){unset($pgenre[$key]);}
      }
      $pgenre = array_values($pgenre);
      return $pgenre;
    }

    //posts
    function genPost($prow, $extent = 0, $public = false){
      $row = $prow;
      $post = $this->postStencil;
      $postId = $row["id"];
      $postAge = $this->givePostAge($row["reg_date"]);
      $postText = $this->core->parse->parse($row["experience"], 1);
      $postTitle = $this->core->purify($row["names"], "full");
      $postLink = "/".strtolower($this->core->lang)."/content/testimonials/post/".$postId;
      $fullPostLink = "https://".$_SERVER["SERVER_NAME"].$postLink;

      $contractArr = $this->core->contracts->giveArr($row["contract"], true);
      if ($contractArr == []){return false;}
      $contractImg = $contractArr["img"];
      $contractName = $contractArr["name"];

      $post = str_replace("post-banner%%", $contractImg, $post);
      $post = str_replace("%post-title", $postTitle, $post);
      $post = str_replace("%%contract-name", $contractName, $post);
      $post = str_replace("%%posted-date", $postAge, $post);
      $post = str_replace("%%sharer-title", $this->core->giveWord(59), $post);
      $post = str_replace("%%short-post-link", $postLink, $post);
      $post = str_replace("%%post-link", $fullPostLink, $post);
      $post = str_replace("%%hashtags", $this->core->giveWord(25), $post);
      if ($extent > 0){
        $post = str_replace("ADDMAINPOSTCLASS", "bigpost", $post);
      }

      $post = str_replace("%%post-text", $postText, $post);
      return $post;
    }

    function genSortCont($feed) {
      $sortCont = <<<MAC
      <div class="sort-cont rectangle" id="sortcont$feed" target-feed="$feed" onload="sortify(this, '$feed')" >
        <div class="sort-tab selected" sort-by="new">
          <i class="fa-solid fa-sun"></i> New
        </div>
        <div class="sort-tab" sort-by="random">
          <i class="fas fa-dice-d6"></i> Random
        </div>
        <div class="sort-tab" sort-by="old">
          <i class="fa-solid fa-moon"></i> Old
        </div>
      </div>
      <div class="returnToTopEr fakelink" onclick="backToTop('sortcont$feed')" id='backToTop'>
        <i class="fas fa-arrow-up"></i> Back to top
      </div>
      MAC;
      return $sortCont;
    }

    //miscellaneous post tools
    function givePostAge($regdate){
      $now = new DateTime();
      $ago = new DateTime($regdate);
      $absdiff = $now->diff($ago)->format("%a");
      if ($absdiff > 7) {return $ago->format("dS F Y");}

      $diff = $now->diff($ago);
      $diff->w = floor($diff->d / 7);
      $diff->d -= $diff->w * 7;

      $stringNames = array(
          'y' => [$this->core->giveWord(62), $this->core->giveWord(63)],
          'm' => [$this->core->giveWord(64), $this->core->giveWord(65)],
          'w' => [$this->core->giveWord(66), $this->core->giveWord(67)],
          'd' => [$this->core->giveWord(68), $this->core->giveWord(69)],
          'h' => [$this->core->giveWord(70), $this->core->giveWord(71)],
          'i' => [$this->core->giveWord(72), $this->core->giveWord(73)],
      );
      foreach ($stringNames as $k => $v) {
        if ($diff->$k > 0){
          $units = $v[1]; if ($diff->$k==1){$units=$v[0];}
          $text = $this->core->giveWord(60)." ".$diff->$k." ".$units." ".$this->core->giveWord(61);
          return $text;
        }
      }
      return $this->core->giveWord(74);
    }

    public $postStencil =  <<<MACss
    <div class="post">
      <div class="main-post ADDMAINPOSTCLASS">
        <div class="main-post-banner" load-image="post-banner%%">
        </div>
        <div class="main-post-content">
          <h3 class="main-post-title">%post-title</h3>
          <p class="subtitle">%%contract-name · %%posted-date</p>
          <div>
            %%post-text
          </div>
        </div>
        <a class="main-post-overlay" href="%%short-post-link"></a>
      </div>
      <div class="bottom-infos-sharer">
        <a href="http://www.reddit.com/submit?title=%%sharer-title&url=%%post-link" target="_blank" class="fa-brands fa-reddit"></a>
        <a href="https://twitter.com/intent/tweet?text=%%sharer-title&url=%%post-link&hashtags=%%hashtags" target="_blank" class="fa-brands fa-twitter"></a>
        <a class="fa fa-link fancyjump" onclick="navigator.clipboard.writeText('%%post-link');"></a>
      </div>
    </div>
    MACss;
}


?>
