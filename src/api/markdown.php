<?php
   
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
         switch ( $methods ) {
            case "POST":
               $this -> write();
               break;
            case "GET":
               $this -> read();
               break;
         }
      }
      private function getFile($path) {
         $path = str_replace("/^\\/", "", $path);
         switch ( strtolower($path) ) {
            case "tutorial":
               return __DIR__."/../../markdown/tutorial.md";
            case "rules":
               return __DIR__."/../../markdown/rules.md";
            case "faqs":
               return __DIR__."/../../markdown/faqs.md";
         }
      }
      private function read() {
         if ( isset($_GET["path"]) ) {
            if ( is_file($this -> getFile($_GET["path"])) ) {
               echo json_encode([
                  "error" => 0,
                  "md" => file_get_contents($this -> getFile($_GET["path"]))
               ]);
            } else {
               echo json_encode([
                  "error" => 1,
                  "mess" => "File not is exists."
               ]);
            }
         }
      }
      private function write() {
         if ( isset($_POST["path"]) && isset($_POST["md"]) ) {
            echo json_encode([
               "error" => file_put_contents($this -> getFile($_POST["path"]), $_POST["md"])
            ]);
         }
      }
   }   
?>