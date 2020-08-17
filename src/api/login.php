<?php
   require_once __DIR__."/../../modules/sql_connect.php";
   require_once __DIR__."/../modules/OAuth.php";
   
   if ( isset($_POST["username"]) && isset($_POST["password"]) ) {
      OAuth::setJWT([
         "sub" => "admin",
         "exp" => time() + 100000000000,
         "scopes" => (object) [
            "all-app" => (object) [
               "r" => true,
               "w" => true
            ]
         ]
      ]);
      echo json_encode([
         "error" => 0
      ]);
   }
?>