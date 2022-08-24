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

  function giveAll() {
    $response = "";
    $query = "SELECT * FROM contracts";
    if ($return = $this->conn->query($query)){
      while ($row = $return->fetch_assoc()){
        $response .= $this->giveOne($row);
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
      if (count($info)>0){
        $spacer = false; $description .= "<span class='info'>";
        foreach ($info as $key => $value){
          if ($spacer){$description .= " &#183; "; }else {$spacer = true;}
          $description .= $value." ".$key;
        }
        $description .= "</span><br>";
      }
      $description .= $row["description"];

      $contractStencil = str_replace("%%contract_img", $this->core->fetchFileUrl($row["img"], "thumbnail.png", 2), $contractStencil);
      $contractStencil = str_replace("%%contract_title", $name, $contractStencil);
      $contractStencil = str_replace("%%contract_description", $description, $contractStencil);
      $dlbutts = "";
      if (isset($files["pdf"])){
        $dlbutts .= '<a href="'.$this->core->fetchFileUrl($files["pdf"], $this->core->purate($name).".pdf", 2).'" target="_blank"><button class="button smal"><i class="fa-solid fa-arrow-up"></i>  view</button></a>';
      }
      foreach ($files as $filetype => $link){
        $dlbutts .= '<a href="'.$this->core->fetchFileUrl($link, $this->core->purate($name).".".$filetype, 1, $row["id"]).'"><button class="button smal"><i class="fa-solid fa-arrow-down"></i> .'.$filetype.'</button></a>';
      }
      $contractStencil = str_replace("%%download_buttons", $dlbutts, $contractStencil);
      return $contractStencil;
    }
    return "";
  }
  function parseContract($row){
    $files = json_decode($row["files"], true);
    if (isset($files[$this->core->lang])){$row["files"] = $files[$this->core->lang];} else {return false;}
    $row["name"] = json_decode($row["name"], true)[$this->core->lang];
    $row["description"] = json_decode($row["description"], true)[$this->core->lang];
    return $row;
  }

}
?>
