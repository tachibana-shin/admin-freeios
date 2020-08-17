<?php
   require_once __DIR__."/../../sql_connect.php";
   
   $methods = $_SERVER["REQUEST_METHOD"];
   if ( isset($_POST["action"]) && !!$_POST["action"] ) {
      $methods = strtoupper( $_POST["action"] );
   }
   
   switch ( $methods ) {
      case "PUT":
         if ( $_POST["action"] ) {
         	$_PUT = $_POST;
         } else {
            $_PUT = (array) json_decode(file_get_contents("php://input")); 
		   };
         break;
      case "DELETE":
         $_DELETE = (array) json_decode(file_get_contents("php://input"));
         break;
   }
   
   new class {

      public function __construct() {
         global $methods;
         $this -> initSQL();
         switch ( $methods ) {
            case "PUT":
               // @update
               $this -> update();
               break;
            case "GET":
               // @read
               $this -> read();
               break;
         }
      }
      private function initSQL() {
         global $sql;
         $sql -> query("create table if not exists iCloud (
               id init not null auto_increment,
               username tinytext not null,
               password tinytext not null,
               show tinyint(1) default 1,
               primary key(id)
            )");
      }
      private function read() {
         global $sql;
         $limit = 0;
         $offset = 0;
         
         if ( isset($_GET["limit"]) && !empty($_GET["limit"]) ) {
            $limit = (int) $_GET["limit"] || 0;
         }
         if ( isset($_GET["offset"]) && !empty($_GET["offset"]) ) {
            $offset = (int) $_GET["offset"] || 0;
         }
      
         $result = $sql -> query("select * from iCloud limit $limit offset $offset");
         $iclouds = [];
         if ( $result -> num_rows > 0 ) {
            while ( $row = $result -> free_result() ) {
               array_push($iclouds, [
                  "id" => $row["id"],
                  "username" => $row["username"],
                  "password" => $row["password"],
                  "show" => $row["show"]
               ]);
            }
         }
         echo json_encode($iclouds);
      }
      private function update() {
         global $sql;
         global $_PUT;
         /*
            $_PUT
               $_ADD
               $_DELETE
         */
         
         if (
            isset($_PUT["ADD"]) && 
            is_array($_PUT["ADD"])
         ) {
            foreach ( $_PUT["ADD"]["username"] as $value ) {
               $sql -> query("insert into iCloud (username, password, show) values ('".addslashes($value["username"])."', ".addslashes($value["password"])."', ".((int) $value["show"]).")");
            }
         }
         
         if ( isset($_PUT["DELETE"]) && is_array($_PUT["DELETE"]) ) {
            foreach ( $_PUT["DELETE"] as $value ) {
               $sql -> query("delete iCloud where id = ".((int) $value));
            }
         }
         
         if ( (isset($_PUT["ADD"]) || isset($_PUT["DELETE"])) && !$sql -> error ) {
            echo json_encode([
               "error" => 0,
               "mess" => ""
            ]);
         } else {
            if ( $sql -> error ) {
               echo json_encode([
                  "error" => 1,
                  "mess" => $sql -> error
               ]);
            } else {
               echo json_encode([
                  "error" => 1,
                  "mess" => "Wrong / missing parameters sent. please check again."
               ]);
            }
         }
      }
   }
?>