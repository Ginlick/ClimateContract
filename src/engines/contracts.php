<?php
class contracts {
  public $conn = null;
  public $contractStencil =  <<<MACss
    <div class="contract-box">
      <div class="contract-thumbnail">
        <div class="squareCont">
          <div class="square">
            <img src="%%contract_img" />
          </div>
        </div>
      </div>
      <div class="contractCont">
        <p class="main-contract-title"><b>%%contract_title</b></p>
        <p>%%contract_description</p>
      </div>
      <div class="buttCont">
        %%download_buttons
      </div>
    </div>
  MACss;

  function __construct($core) {
    $this->core = $core;
    $this->conn = $core->conn;
  }

  function giveMain() {
    $response = "<p>".$this->core->giveWord("e-1")."</p>";
    $query = "SELECT * FROM contracts LIMIT 1";
    if ($return = $this->conn->query($query)){
      while ($row = $return->fetch_assoc()){
        if ($contract = $this->parseContract($row)) {
          $response = "";
          $name = $contract["name"];
          $files = $contract["files"];
          if (count($files)<1){return "<p>".$this->core->giveWord(38)."</p>";}
          $response .= "<div class='dlButtonCont'>";
          foreach ($files as $filetype => $link){
            $response .= '<a href="'.$this->core->fetchFileUrl($link, $this->core->purate($name).".".$filetype, 1, $contract["id"]).'"><button class="button" onclick="downloadedC(\''.$this->giveArticleLink($contract).'\');"><i class="fa-solid fa-arrow-down"></i> .'.$filetype.'</button></a>';
          }
          $response .= "</div>";
          if (isset($files["pdf"])){
            //$response .= '<a href="'.$this->core->fetchFileUrl($files["pdf"], $this->core->purate($name).".pdf", 2).'" target="_blank">'.$this->core->giveWord(89).'</a>';
          }
        }
      }
    }
    return $response;
  }
  function giveAll($type = "contracts") {
    $response = "";
    $query = "SELECT * FROM contracts";
    if ($return = $this->conn->query($query)){
      while ($row = $return->fetch_assoc()){
        if ($type == "articles"){
          if ($row["articleLink"]!=""){
            $response .= $this->giveOneArticle($row);
          }
        }
        else if ($type == "contracts"){
          $response .= $this->giveOne($row);
        }
      }
    }
    if ($response == ""){
      $response = "<p>".$this->core->giveWord(38)."</p>";
    }
    return $response;
  }
  function giveArr($id = "", $single = false) {
    $response = [];
    $query = "SELECT * FROM contracts";
    if ($id != ""){
      $query .= " WHERE id = $id";
    }
    if ($return = $this->conn->query($query)){
      while ($row = $return->fetch_assoc()){
        if ($single){
          $response = $this->parseContract($row);
        }
        else {
          $response[$row["id"]] = $this->parseContract($row);
        }
      }
    }
    return $response;
  }

  function giveOne($row){
    if ($row = $this->parseContract($row)){
      $contractStencil = $this->contractStencil;
      $files = $row["files"];
      $name = $row["name"];
      $description = "";

      $info = [];
      if ($row["downloads"]>10){$info["downloads"] = $row["downloads"];}
      $query = "SELECT id FROM testimonials WHERE contract = ".$row["id"];
      if ($result = $this->conn->query($query)){
        $info["testimonials"] = mysqli_num_rows($result);
      }

      $hasExtra = false;
      if (count($info)>0){
        $hasExtra = true;
        $spacer = false; $description .= "<span class='info'>";
        foreach ($info as $key => $value){
          if ($spacer){$description .= " &#183; "; }else {$spacer = true;}
          $description .= $value." ".$key;
        }
        $description .= "</span>";
      }
      if ($hasExtra){
        $description .= "<br>";
      }
      $description .= $row["description"];
      if ($row["articleLink"] != ""){
        $description .= "<br><span><a href='".$this->giveArticleLink($row)."' target='_blank'>".$this->core->giveWord(92)."</a></span>";
      }

      $contractStencil = str_replace("%%contract_img", $this->core->fetchFileUrl($row["img"], "thumbnail.png", 2), $contractStencil);
      $contractStencil = str_replace("%%contract_title", $name, $contractStencil);
      $contractStencil = str_replace("%%contract_description", $description, $contractStencil);
      $dlbutts = "";
      if (isset($files["pdf"])){
        $dlbutts .= '<a href="'.$this->core->fetchFileUrl($files["pdf"], $this->core->purate($name).".pdf", 2).'" target="_blank"><button class="button smal"><i class="fa-solid fa-arrow-up"></i>  view</button></a>';
      }
      foreach ($files as $filetype => $link){
        $dlbutts .= '<a href="'.$this->core->fetchFileUrl($link, $this->core->purate($name).".".$filetype, 1, $row["id"]).'"><button class="button smal"  onclick="downloadedC(\''.$this->giveArticleLink($row).'\');"><i class="fa-solid fa-arrow-down"></i> .'.$filetype.'</button></a>';
      }
      $contractStencil = str_replace("%%download_buttons", $dlbutts, $contractStencil);
      return $contractStencil;
    }
    return "";
  }
  function parseContract($row){
    $files = json_decode($row["files"], true);
    if (isset($files[$this->core->lang])){$row["files"] = $files[$this->core->lang];} else {return false;}
    $names = json_decode($row["name"], true);
    if (isset($names[$this->core->lang])){$row["name"] = $names[$this->core->lang];} else {return false;}
    $descriptions = json_decode($row["description"], true);
    if (isset($descriptions[$this->core->lang])){$row["description"] = $descriptions[$this->core->lang];} else {$row["description"] = "";}
    return $row;
  }

  function giveOneArticle($row) {
    if ($row = $this->parseContract($row)) {
      $return = "<li class='timeline-item'><div class='timeline-content'>";
      $return .= "<h3>".$row["name"]."</h3>";
      $return .= "<p>".$row["description"]."</p>";
      $return .= "<a class='greylink' href='".$this->giveArticleLink($row)."'>".$this->core->giveWord("92-b")."</a>";
      $return .= "</div><div class='timeline-bar'></div></li>";
      return $return;
    }
  }
  function giveArticleLink($contract){
    return "/content/contracts/article/".$contract["id"]."_".$this->core->purate($contract["name"]);
  }
}
?>
