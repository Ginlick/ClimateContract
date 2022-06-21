<?php

trait coreFunctions {
  function getskey(string $which) {
    if ($which == "captcha"){
      require(dirname(dirname($_SERVER['DOCUMENT_ROOT']))."/keys/captcha.php");
      return $skey;
    }
    else if ($which == "conn"){
      require(dirname(dirname($_SERVER['DOCUMENT_ROOT']))."/keys/connInfo.php");
      return new mysqli($servername, $username, $password, $dbname);
    }
  }
  function setConn() {
    $this->conn = $this->getskey("conn");
  }
  function purate($input, $regex = "basic") {
    //for links
    $input = str_replace(" ", "_", $input);
    return preg_replace($this->regArrayR[$regex], "", $input);
  }
  function purify($input, $regex = "basic") {
    //for sql cleaning & more
    return preg_replace($this->regArrayR[$regex], "", $input);
  }
  function killCache() {
    header("Cache-Control: no-cache, must-revalidate"); //HTTP 1.1
    header("Pragma: no-cache"); //HTTP 1.0
    header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
  }
  function go($place) {
    $this->killCache();
    if (preg_match("/^\/[A-Za-z]{2}\/.*$/", $place) AND isset($this->lang)){
      $place = preg_replace("/^\/[A-Za-z]{2}\//", "/", $place);
      $place = "/".strtolower($this->lang).$place;
    }
    echo "<script>window.location.replace('$place');</script>";
    exit;
  }
}

require_once($_SERVER['DOCUMENT_ROOT']."/engines/errorHandler.php");



class core {
  use coreFunctions;
  public $lang = "EN";
  public $domain = 1;
  public $projectName = "Students Travel Green";
  public $extraModules = [];

  public $navBarElements = [1 => ["name"=>1, "href"=>"/home"], 2 => ["name"=>2, "href"=>"/contracts"], 3=> ["name"=>3, "href"=>"/testimonials", "visibility"=>1]];
  public $langs = ["EN", "DE"];
  public $regArrayR = [
    "basic" => "/[^A-Za-z0-9_]/",
    "number" => "/[^0-9]/",
    "quotes" => "/[\"']/",
    "full" => "/[^A-Za-z0-9àèìòùÀÈÌÒÙáéíóúýÁÉÍÓÚÝâêîôûÂÊÎÔÛãñõÃÑÕäëïöüÿÄËÏÖÜŸçÇßØøÅåÆæœĀāŌо̄Ūū_&\/,\(\)\.\-%:\? ]/",
    "dicWord" => "/[^A-Za-zàèìòùÀÈÌÒÙáéíóúýÁÉÍÓÚÝâêîôûÂÊÎÔÛãñõÃÑÕäëïöüÿÄËÏÖÜŸçÇßØøÅåÆæœĀāŌо̄Ūū\-'%_ ]/"
  ];

  function __construct($domain = 0) {
    $this->setConn();

    $this->domain = $domain;
    if (isset($_COOKIE["lang"])){
      if (in_array($_COOKIE["lang"], $this->langs)){
        $this->lang = $_COOKIE["lang"];
      }
    }
    $this->urllang = "/".strtolower($this->lang);
    $strJsonFileContents = file_get_contents($_SERVER['DOCUMENT_ROOT']."/service/language/words.json");
    $this->wordArr = json_decode(preg_replace('/[\x00-\x1F]/', '', $strJsonFileContents), true, 512, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
  }
  function useContracts() {
    require_once($_SERVER['DOCUMENT_ROOT']."/engines/contracts.php");
    $this->contracts = new contracts($this);
  }
  function useBlogs() {
    array_push($this->extraModules, "blogs");
    require_once($_SERVER['DOCUMENT_ROOT']."/engines/blogs.php");
    require_once($_SERVER['DOCUMENT_ROOT']."/engines/parser.php");
    $this->parse = new parser;
    $this->useContracts();
    return new blogEngine($this);
  }

  function giveHeader() {
    $return = '
    <header class="header">
      <div class="header-wrapper">
        <div class="logo-bigcont">
          <a href="'.$this->urllang.'/home">
            <div class="logo-cont">
              <img src="/visuals/logo.png" alt="'.$this->giveWord(4).'"/>
            </div>
          </a>
        </div>
        <div class="menu-cont">
            <p class="nomargin"><i class="fa-solid fa-bars fakelink" onclick="toggleMenu(this)"></i></p>
        </div>
        <div class="main-nav" id="main-nav">
          <div class="in-main-nav">
          <div class="lang-cont">
            <p>';
    $did = false;
    foreach ($this->langs as $langcode) {
      if ($langcode == $this->lang){continue;}
      if ($did){$return .= ' | ';}else{$did = true;}
      $return .= '<a href="/service/language/switch?tl='.$langcode.'&return='.$_SERVER['REQUEST_URI'].'">'.$langcode.'</a>';
    }
        $return .=  '  </p>
          </div>
          <div class="header-flex">
            <div class="nav-cont">';
    foreach ($this->navBarElements as $selectId => $element){
      if (isset($element["visibility"]) AND $element["visibility"] != 1){continue;}
      if ($selectId == $this->domain) {
        $return .= '<a href="'.$this->urllang.$element["href"].'"><div class="nav-tab selected">'.$this->giveWord($element["name"]).'</div></a>';
        continue;
      }
      $return .= '<a href="'.$this->urllang.$element["href"].'"><div class="nav-tab">'.$this->giveWord($element["name"]).'</div></a>';
    }
    $return .= "</div>
            </div>
          </div>
        </div>
      </div>
    </header>";
    return $return;
  }
  function giveHtmlTitle() {
    if (isset($this->navBarElements[$this->domain]) AND $this->domain > 1){
      return "<title>".$this->giveWord($this->navBarElements[$this->domain]["name"])." | ".$this->projectName."</title>";
    }
    return "<title>".$this->projectName."</title>";
  }

  //language
  function giveWord(int $id) {
    if (isset($this->wordArr[$id][$this->lang])){
      return $this->wordArr[$id][$this->lang];
    }
    return;
  }
  function printWord(int $id){
    echo $this->giveWord($id);
  }

  //gives
  function giveHtmlHeaders() {
    $headers = '
        <meta charset="UTF-8" />
        <link rel="icon" href="/visuals/favicon.png">
        <link rel="stylesheet" type="text/css" href="/styles/style.css">
        <link href="/assets/fontawesome/css/fontawesome.css" rel="stylesheet">
        <link href="/assets/fontawesome/css/solid.css" rel="stylesheet">
        <link href="/assets/fontawesome/css/brands.css" rel="stylesheet">
        ';
    $headers .= $this->giveHtmlTitle();
    if (in_array("blogs", $this->extraModules)){
      $headers .= '<link rel="stylesheet" type="text/css" href="/styles/blog.css">';
    }
    return $headers;
  }
  function giveCorelinks() {
    $headers = '
    <script src="/system/core.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Ubuntu:wght@300;400;500&display=swap" rel="stylesheet">
    <script>
      var mainnav = document.getElementById("main-nav");
      function toggleMenu(menu) {
        if (!menu.classList.contains("fa-rotate-90")) {
          menu.classList.add("fa-rotate-90");
          mainnav.classList.add("shown");
        }
        else {
          menu.classList.remove("fa-rotate-90");
          mainnav.classList.remove("shown");
        }
      }
    </script>
    ';
    if (in_array("blogs", $this->extraModules)){
      $headers .= '<script src="/engines/blogs/blog-feed.js"></script>';
    }
    return $headers;
  }
  function giveFooter() {
    return '
    <footer class="footer">
      <div class="footerList">
        <div class="footerBlock">
          <h3>'.$this->giveWord(20).'</h3>
          <p>
            Monja Simmler · '.$this->giveWord(57).'<br>
            Simon Belt · '.$this->giveWord(58).'
          </p>
          <p>
            <a href="mailto:'.$this->giveWord(21).'" target="_blank">'.$this->giveWord(21).'</a>
          </p>
        </div>
      </div>
      <div class="bottomFooter">
        <div class="flexer">
          <p>© 2022 Green Youth Contract</p>
        </div>
        <div class="flexer">
          <p><a href="https://github.com/Ginlick/ClimateContract" target="_blank">'.$this->giveWord(22).'</a><p>
        </div>
        <div class="flexer sharerCont">
            <p><a href="https://www.facebook.com/sharer/sharer.php?u='.$this->giveWord(23).'" target="_blank" class="fa-brands fa-facebook"></a>
            <a href="http://www.reddit.com/submit?title='.$this->giveWord(24).'!&url='.$this->giveWord(23).'" target="_blank" class="fa-brands fa-reddit"></a>
            <a href="https://twitter.com/intent/tweet?text='.$this->giveWord(24).'!%0A&url='.$this->giveWord(23).'&hashtags='.$this->giveWord(25).'" target="_blank" class="fa-brands fa-twitter"></a>
            <a class="fa fa-link fancyjump" onclick="navigator.clipboard.writeText(\''.$this->giveWord(23).'\');"></a></p>
        </div>
      </div>
    </footer>
    ';
  }
}



?>
