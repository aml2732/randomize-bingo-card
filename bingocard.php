<?php
  function main($args){
    //$json = json_decode(file_get_contents('php://input'), true);
    $json = json_decode($args["__ow_body"], true);
    $size = $json["payload"]["size"];
    $bingocard = $json["payload"]["bingocard"];
    $html="";

    for($i = 0; $i<$size; $i++){
      for($k = 0; $k<$size; $k++){
        $html.="<div class='box'>".$bingocard[($i*$size)+$k]."</div>";
      }
      $html.="<br/>";
    }
    $result = array(
      "body" => $html,
    );
    return $result;
  }
?>
