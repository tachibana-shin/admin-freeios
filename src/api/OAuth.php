<?php
   require_once __DIR__."/../libs/JWT.php";
   use \Firebase\JWT\JWT;
   
   
   class OAuth {
       const KEYJWT = $_SERVER["HTTP_HOST"];
       static private function getCookie() {
          if ( isset($_COOKIE["access_token"]) && !empty($_COOKIE["access_token"]) ) {
             return $_COOKIE["access_token"];
          } else {
             return NULL;
          }
       }
       static private function setCookie($val) {
          setcookie("access_token", $val, strtotime("+30days"), "/", NULL, NULL, true);
       }
       static public function getCurrentUser() {
          if ( empty(self::getCookie()) ) {
             return NULL;
          } else {
             return (array) JWT::decode(self::getCookie(), self::KEYJWT, ["HS256"]);
          }
       }
       static public function setJWT($payload) {
          $token = (string) JWT::encode($payload, KEYJWT);
               
          JWT::$leeway = 30 * 24 * 3600;
          self::setCookie($token);
          return $token;
       }
   }

   
?>