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
    if (preg_match("/^\//", $place) AND isset($this->lang)){
      if (preg_match("/^\/[A-Za-z]{2}\/.*$/", $place)){
        $place = preg_replace("/^\/[A-Za-z]{2}\//", "/", $place);
      }
      $place = "/".strtolower($this->lang).$place;
    }
    echo "<script>window.location.replace('$place');</script>";
    exit;
  }
}

require_once($_SERVER['DOCUMENT_ROOT']."/engines/errorHandler.php");



class core {
  use coreFunctions;
  public $lang = "DE";
  public $domain = 1;
  public $projectName = "Climate Contract";
  public $extraModules = [];

  public $navBarElements = [1 => ["name"=>1, "href"=>"/home", "tabs"=>[["name"=>"1-2","href"=>"/content/home/info"]]], 2 => ["name"=>2, "href"=>"/contracts"], 3=> ["name"=>3, "href"=>"/testimonials", "visibility"=>1]];
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

    $url = $_SERVER['REQUEST_URI'];
    if (preg_match("/^\/([a-z]{2})\/.*$/", $url, $matches)){
      if ($matches[1] != $this->lang){
        $this->switchLang($matches[1]);
      }
    }
  }
  function useContracts() {
    require_once($_SERVER['DOCUMENT_ROOT']."/engines/contracts.php");
    $this->contracts = new contracts($this);
  }
  function useParser($parseClear = false) {
    if (!isset($this->parser)){
      require_once($_SERVER['DOCUMENT_ROOT']."/engines/parser.php");
      return new parser($parseClear);
    }
  }
  function useBlogs() {
    array_push($this->extraModules, "blogs");
    require_once($_SERVER['DOCUMENT_ROOT']."/engines/blogs.php");
    $this->useContracts(); $this->parse = $this->useParser();
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
      $inset = "";
      if ($selectId == $this->domain) {
        $inset = "selected";
      }
      $return .= '<div class="nav-tab-cont"><a href="'.$this->urllang.$element["href"].'"><div class="nav-tab '.$inset.'">'.$this->giveWord($element["name"]).'</div></a>';
      if (isset($element["tabs"])) {
        $return .= "<ul class='nav-tab-tabscont'>";
        foreach ($element["tabs"] as $tab){
          $return .= "<a href='".$tab["href"]."'><li class='nav-smalltab'>".$this->giveWord($tab["name"])."</li></a>";
        }
        $return .= "</ul>";
      }
      $return .= "</div>";
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
  function launchParser() {
    if (!isset($this->textParse) OR gettype($this->textParse) != "object"){
      $this->textParse = $this->useParser(true);
    }
  }
  function giveWord($id, $parseit = false) {
    if (isset($this->wordArr[$id][$this->lang])){
      $word = $this->wordArr[$id][$this->lang];
      if ($parseit){
        $this->launchParser();
        $word = $this->textParse->parse($word, 1);
      }
      return $word;
    }
    return;
  }
  function printWord($id, $parseit = false){
    echo $this->giveWord($id, $parseit);
  }
  function useText() {
    $this->launchParser();
    $strJsonFileContents = file_get_contents($_SERVER['DOCUMENT_ROOT']."/service/language/text.json");
    $this->textArr = json_decode(preg_replace('/[\x00-\x1F]/', '', $strJsonFileContents), true, 512, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
  }
  function giveText($id) {
    if (!isset($this->textArr)){$this->useText();}
    if (isset($this->textArr[$id][$this->lang])){
      $text = $this->textParse->parse($this->textArr[$id][$this->lang], 1);
      if (preg_match_all("/^.*(\[word:([a-z0-9\-]+)\]).*$/m", $text, $lineMatches, PREG_PATTERN_ORDER) != false){$text = $this->textInsertWords($text, $lineMatches);}
      return $text;
    }
    return;
  }
  function textInsertWords($text, $lineMatches){
    foreach ($lineMatches[1] as $key => $fullMatch){
      $wordId = $lineMatches[2][$key];
      $word = $this->giveWord($wordId);
      $text = str_replace($fullMatch, $word, $text);
    }
    return $text;
  }
  function printText($id){
    echo $this->giveText($id);
  }
  function switchLang(string $wantlang){
    $wantlang = strtoupper($wantlang);
    if (in_array($wantlang, $this->langs)){
      $this->lang = $wantlang;
      setcookie("lang", $wantlang, time()+57820000, "/");
      return true;
    }
    return false;
  }

  //gives
  function giveHtmlHeaders() {
    $headers = '
        <meta charset="UTF-8" />
        <link rel="icon" href="/visuals/favicon.png">
        <link rel="stylesheet" type="text/css" href="/styles/style.v2.css">
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

      var allLinks = document.getElementsByTagName("a");
      for (let link of allLinks){
        let linktext = link.getAttribute("href");
        if (typeof(linktext) == "string" && linktext.match(/^\//)){
          console.log(linktext);
          if (linktext.match(/^\/[A-Za-z]{2}\/.*$/)){
            linktext = linktext.replace(/^\/[A-Za-z]{2}\//, "/");
          }
          linktext = "/'.strtolower($this->lang).'" + linktext;
          link.setAttribute("href", linktext);
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
        <div class="footerBlock">
          <h3>'.$this->giveWord(84).'</h3>
          <p>
            <a href="/content/legal/impressum">'.$this->giveWord(80).'</a><br>
            <a href="/content/legal/privacy">'.$this->giveWord(81).'</a>
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

  //miscellaneous
  function fetchFileUrl($filename, $name, $viewmode = 2, $count = 0, $dir = null) {
    $text = '/engines/download?file='.$filename.'&name='.$name.'&viewmode='.$viewmode.'&count='.$count;
    return $text;
  }
}



?>
