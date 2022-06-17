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
    return $response;
  }

  function giveOne($row){
    $contractStencil = $this->contractStencil;
    $files = json_decode($row["file"], true);
    if (isset($files[$this->core->lang])){$files = $files[$this->core->lang];} else {return "";}
    $contractStencil = str_replace("%%contract_img", $row["img"], $contractStencil);
    $contractStencil = str_replace("%%contract_title", $row["name"], $contractStencil);
    $contractStencil = str_replace("%%contract_description", $row["description"], $contractStencil);
    $dlbutts = "";
    if (isset($files["pdf"])){
      $dlbutts .= str_replace("%%view_contract", $files["pdf"], '<a href="%%view_contract" target="_blank"><button class="button smal"><i class="fa-solid fa-arrow-up"></i> view</button></a>');
    }
    foreach ($files as $filetype => $link){
      $dlbutts .= '<a href="/engines/download?file='.$link.'&name='.$this->core->purate($row["name"]).".".$filetype.'"><button class="button smal"><i class="fa-solid fa-arrow-down"></i> .'.$filetype.'</button></a>';
    }
    $contractStencil = str_replace("%%download_buttons", $dlbutts, $contractStencil);
    return $contractStencil;
  }

}
?>
