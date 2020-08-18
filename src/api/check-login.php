<?php
   require_once __DIR__."/../modules/OAuth.php";
   
   if ( $data = OAuth::getCurrentUser() ) {
      echo json_encode([
         "logined" => 1,
         "data" => $data
      ]);
   } else {
      echo json_encode([
         "logined" => 0,
         "data" => []
      ]);
   }
?>