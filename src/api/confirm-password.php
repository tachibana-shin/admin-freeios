<?php
   require_once __DIR__."/../../modules/sql_connect.php";
   require_once __DIR__."/../modules/OAuth.php";
   
   if ( empty(OAuth::getCurrentUser()) ) {
      echo json_encode(OAuth::errorLogin());
      exit;
   }
   
   if ( isset($_POST["password"]) ) {
      $user = addslashes(OAuth::getCurrentUser()["user"]);
      $pass = md5($_POST["password"]); 
      
      $result = $sql -> query("select * from AccountAdmin where username = '$user' and password = '$pass'");
      echo $result -> num_rows > 0 ? json_encode([
         "error" => 0,
         "mess" => ""
      ]) : json_encode([
         "error" => 1,
         "mess" => "Password failed."
      ]);
   } else {
      echo json_encode([
         "error" => 1,
         "mess" => "Wrong param send to server."
      ]);
   }
?>