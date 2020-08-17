<?php

   $query = "select * from Apos where ";
   if ( isset($_GET["name"]) && !!$_GET["name"] ) {

		$query .= "name = '".addslashes(str_replace("-", " ", str_replace(" ", "+", $_GET["name"]))."'");
   }
   else if ( isset($_GET["id"]) && !!$_GET["id"] ) {
      $query .= "id = ".addslashes($_GET["id"]);
   }
   else {
      echo json_encode([
         "error" => 1,
         "mess" => "Request no validate."
      ]);
      die();
   }
		
	$result = $sql -> query( $query );
		//echo $sql -> error;
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
		foreach ( ["name", "author", "description", "category", "account", "id"] as $val )
		   $app[$val] = stripslashes ($tmp[$val]);
	}
		
	$result -> free_result();
		
	echo json_encode($app);
?>