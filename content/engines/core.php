<?php

trait basicElements {
  function giveHtmlHeaders() {
    $headers = '
        <meta charset="UTF-8" />
        <link rel="icon" href="/visuals/favicon.png">
        <link rel="stylesheet" type="text/css" href="/styles/style.css">
        <link href="/assets/fontawesome/css/fontawesome.css" rel="stylesheet">
        <link href="/assets/fontawesome/css/solid.css" rel="stylesheet">
        ';
    $headers .= $this->giveHtmlTitle();
    return $headers;
  }
  function giveCorelinks() {
    $headers = '
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Ubuntu:wght@300;400;500&display=swap" rel="stylesheet">
    ';
    return $headers;
  }
}
trait coreFunctions {
  function setConn() {
    $servername = "localhost";
    $username = "aufregendetage";
    $password = "vavache8810titigre";
    $dbname = "climatecontract";
    $this->conn = new mysqli($servername, $username, $password, $dbname);
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
    echo "<script>window.location.replace('$place');</script>";
    exit;
  }
}

require_once($_SERVER['DOCUMENT_ROOT']."/engines/errorHandler.php");



class core {
  use basicElements;
  use coreFunctions;
  public $lang = "EN";
  public $domain = 1;
  public $projectName = "Students Travel Green";

  public $navBarElements = [1 => ["name"=>"Home", "href"=>"/home"], 2 => ["name"=>"Download Contract", "href"=>"/contracts"], 3=> ["name"=>"Testimonials", "href"=>"/testimonials", "visibility"=>0]];
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
  }
  function useContracts() {
    require_once($_SERVER['DOCUMENT_ROOT']."/engines/contracts.php");
    $this->contracts = new contracts($this);
  }

  function giveHeader() {
    $return = '
    <header class="header">
      <div class="header-wrapper">
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
          <a href="/home">
            <div class="logo-cont">
              <img src="/visuals/logo.png" alt="Climate Contract logo"/>
            </div>
          </a>
          <div class="nav-cont">';
    foreach ($this->navBarElements as $selectId => $element){
      if (isset($element["visibility"]) AND $element["visibility"] != 1){continue;}
      if ($selectId == $this->domain) {
        $return .= '<a href="'.$element["href"].'"><div class="nav-tab selected">'.$element["name"].'</div></a>';
        continue;
      }
      $return .= '<a href="'.$element["href"].'"><div class="nav-tab">'.$element["name"].'</div></a>';
    }
    $return .= "</div>
        </div>
      </div>
    </header>";
    return $return;
  }
  function giveHtmlTitle() {
    if (isset($this->navBarElements[$this->domain]) AND $this->domain > 1){
      return "<title>".$this->navBarElements[$this->domain]["name"]." | ".$this->projectName."</title>";
    }
    return "<title>".$this->projectName."</title>";
  }
}



?>
