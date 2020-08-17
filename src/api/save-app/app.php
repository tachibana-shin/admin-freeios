<?php
   
   require_once __DIR__."/../../modules/sql_connect.php";
   require_once __DIR__."/../../modules/App.php";
   require_once __DIR__."/../../modules/TinyLink.php";
   
   $methods = $_SERVER["REQUEST_METHOD"];
   if ( isset($_POST["action"]) && !!$_POST["action"] ) {
      $methods = strtoupper( $_POST["action"] );
   }
         
   switch ( $methods ) {
      case "PUT":
         parse_str(file_get_contents("php://input"), $_PUT);
         break;
      case "DELETE":
         parse_str(file_get_contents("php://input"), $_DELETE);
         break;
   }
         
   new class {
      public function __construct() {
         
         switch ( $methods ) {
            case "POST":
               // @upload app
               $this -> write();
               break;
            case "PUT":
               // @update app
               $this -> edit();
               break;
            case "DELETE":
               // @remove app
               $this -> remove();
               break;
            case "GET":
               // @get app
               $this -> read();
               break;
         }
   
      }
      private function invalid() {
         echo json_encode([
            "error" => 1,
            "mess" => "Wrong / missing parameters sent. please check again."
         ]);
      }
      private function valid($name, $object = $_POST) {
         return isset($object[$name]) && !!trim($object[$name]);
      }
      private function toSupport($str) {
         return explode(",", str_replace(" ", "", $str));
      }
      private function write() {
         global $TinyLink;
         global $App;
         
         // @check validated
         
         if (
            $this -> valid("name") && 
            $this -> valid("author") && 
            isset($_FILES["icon"]) && 
            $_FILES["icon"] -> error == 0 && 
            $this -> valid("category") &&
               ( $_POST["category"] == "ipa" ^ $this -> valid("account") ) &&
            $this -> valid("description") &&
            $this -> valid("supports") && 
            count($this -> toSupport($_POST["supports"])) > 0 &&
            $this -> valid("versions") &&
               $this -> valid("urls") &&
            is_array($_POST["versions"]) && 
            is_array($_POST["urls"]) &&
            count($_POST["versions"]) > 0 &&
            count($_POST["versions"]) == count($_POST["urls"])
         ) {
            $vers = [];
            foreach ( $_POST["versions"] as $index => $value ) {
               $vers[$value] = $TinyLink -> createHash($_POST["urls"][$index]);
            }
            
            $args = (object) [];
            foreach( ["name", "author", "description", "category"] as $key ) {
               $args -> $key = $_POST[$key];
            }
            
            if ( $_POST["category"] != "ipa" ) {
               $args -> account = $_POST["account"];
            }
            
            
            $args -> icon = $_FILES["icon"];
            $args -> versions = $vers;
            $args -> supports = $this -> toSupport($_POST["supports"]);
            echo json_encode($App -> add($args));
         } else {
            $this -> invalid();
         }
      }
      private function edit() {
         global $_PUT;
         global $App;
         global $TinyLink;
         
         // @check validated
         if ( 
            $this -> valid("id", $_PUT) && 
            (
               !$this -> valid("supports", $_PUT) || 
               count($this -> toSupport($_PUT["supports"])) > 0
            ) && (
               (
                  !$this -> valid("versions", $_PUT) &&
                  !$this -> valid("urls", $_PUT)
               ) || (
                  is_array($_PUT["versions"]) && 
                  is_array($_PUT["urls"]) &&
                  count($_PUT["versions"]) > 0 &&
                  count($_PUT["versions"]) == count($_PUT["urls"])
               )
            ) && (
               $this -> valid("category", $_PUT) && 
               $_PUT["category"] == "ipa" ^ $this -> valid("account", $_PUT)
            )
         ) {
            $args = (object) [];
            
            if ( $this -> valid("versions", $_PUT) ) {
               $vers = [];
               foreach ( $_PUT["versions"] as $index => $value ) {
                  $vers[$value] = $TinyLink -> createHash($_PUT["urls"][$index]);
               }
               $args -> versions = $vers;
            }
            
            if ( $this -> valid("supports", $_PUT) ) {
               $args -> supports = $this -> toSupport($_PUT["supports"]);
            }
            
            foreach( ["name", "author", "description", "category"] as $key ) {
               if ( $this -> valid($key, $_PUT) ) {
                  $args -> $key = $_PUT[$key];
               }
            }
            
            if ( $this -> valid("category") &&  $_PUT["category"] != "ipa"
            ) {
               $args -> account = $_PUT["account"];
            }
            
            if ( isset($_FILES["icon"]) && $_FILES["icon"] -> error == 0 ) {
               $args -> icon = $_FILES["icon"];
            }
            
            $args["id"] = $_PUT["id"];
            
            echo json_encode($App -> update($args));
         } else {
            $this -> invalid();
         }
      }
      private function remove() {
         global $_DELETE;
         global $sql;
         if ( $this -> valid("id", $_DELETE) ) {
            
            $result = $sql -> query("select name from Apps where id = ".addslashes($_DELETE['id']));
            
            if ( $result -> num_rows > 0 ) {
               $name = $result -> fetch_array()["name"];
               $result -> free_result();
               if ( is_file("../../upload/".urlencode($name).".png") ) {
                  unlink("../../upload/".urlencode($name));
               }
            }
            
            if ( $sql -> query("delete from Apps where id = ".addslashes($_DELETE['id'])) ) {
               echo json_encode([
                  "error" => 0,
                  "mess" => ""
               ]);
            } else {
               echo json_encode([
                  "error" => 1,
                  "mess" => $sql -> error
               ]);
            }
         } else {
            $this -> invalid();
         }
      }
      private function read() {
         global $sql;
         global $TinyLink;
         
         $query = "select * from Apps where ";
         if ( isset($_GET["name"]) && !!$_GET["name"] ) {

		      $query .= "name = '".($sql -> real_escape_string(str_replace("-", " ", str_replace(" ", "+", $_GET["name"])))."'");
         }
         else if ( isset($_GET["id"]) && !!$_GET["id"] ) {
            $query .= "id = ".($sql -> real_escape_string((int)$_GET["id"]))." ";
         }
         else {
            $this -> invalid();
            die();
         }
	
	      $result = $sql -> query( $query );
	      $app = [];
	
	      if ( $result -> num_rows > 0 ) {
		      $tmp = $result -> fetch_array();

		      $versions = unserialize($tmp["versions"]);
      
            $arrayVersions = [];
            
		      foreach ( $versions as $key => $value ) {
			      array_push($arrayVersions, [$key, $TinyLink -> findLink($value)]);
		      }
			
		      $app["versions"] = $arrayVersions;
		
	         $app["supports"] = unserialize($tmp["supports"]);
		      $app["images"] = BASE_URI."/upload/".urlencode(urlencode($tmp["name"])).".png";
		      foreach ( ["name", "author", "description", "category", "account", "id"] as $val ) {
		         $app[$val] = stripslashes ($tmp[$val]);
		      }
	         $app["error"] = 0;
	         $app["mess"] = "";
	      }
		
	      $result -> free_result();
	
	      if ( empty($app) ) {
	         echo json_encode([
	            "error" => 1,
	            "mess" => "App Not Found."
	         ]);
	      } else {
	         echo json_encode($app);
	      }
      }
   };
?>