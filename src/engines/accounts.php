<?php
class accounts {
  public $loggedIn = false;

  function __construct($core) {
    $this->core = $core;
    $this->conn = $core->conn;

    session_start();
    if (isset($_SESSION["id"])){
      $this->loggedIn = $this->accInfo($_SESSION["id"]);
    }
  }

  function accInfo($value, string $type = "id") {
    $query = 'SELECT * FROM accounts WHERE '.$type.' = "'.$value.'"';
    if ($result = $this->conn->query($query)){
      while ($row = $result->fetch_assoc()) {
        $row["settings"]=json_decode($row["settings"], true);
        return $row;
      }
    }
    return false;
  }
  function logIn($value, $type = "id") {
    if ($this->loggedIn = $this->accInfo($value, $type)){
      $_SESSION["id"] = $this->loggedIn["id"];
      return true;
    }
    return false;
  }
  function logOut() {
    $this->loggedIn = false;
    unset($_SESSION["id"]);
  }
  function createAccount($email){
    if (!$this->accInfo($email, "email")){
      $query = 'INSERT INTO accounts (email) VALUES ("'.$email.'")';
      if ($this->conn->query($query)){
        if ($this->logIn($email, "email")){
          return true;
        }
      }
    }
    return false;
  }

  function check($email) {
    if ($this->logIn($email, "email")){
      if ($this->loggedIn["status"]=="active"){
        return true;
      }
    }
    else {
      if ($this->createAccount($email)){
        return true;
      }
    }
    return false;
  }
}
?>
