<?php
  function main($args){
    //$json = json_decode(file_get_contents('php://input'), true);
    $json = json_decode($args["__ow_body"], true);
    $size = $json["payload"]["size"];
    $contentarr = $json["payload"]["spaces"];

    function findMiddleNumber($squaresize){
      $quotient = $squaresize/2;
      return round($quotient, 0, PHP_ROUND_HALF_UP);
    }

    $middleSpot = findMiddleNumber($size);

    shuffle($contentarr);

    $skip = (($size)*($middleSpot - 1) + $middleSpot - 1);
    array_splice($contentarr,$skip, 0, ["FREE"]);

    $result = array(
        "bingocard" => $contentarr,
        "size" => $size,
    );
    //var_dump($result);
    return $result;
  }
 ?>
