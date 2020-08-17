<?php
   
   header("Access-Control-Allow-Origin: *");
   header('Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS');
   header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
   	
   if ( isset($_POST["page"]) ) {
      
      $query = "select name, author, category, downloads, views from Apps ";
      
      if ( isset($_POST["category"]) ) {
         $query .= "where category = '$_POST[category]' ";
      }
      if ( isset($_POST["sortby"]) ) {
         switch ( $_POST["sortby"] ) {
            case "a-z":
               $query .= "order by name asc ";
               break;
            case "z-a":
               $query .= "order by name desc ";
               break;
            case "time-up":
               $query .= "order by timeupload asc ";
               break;
            case "time-down":
               $query .= "order by timeupload desc ";
         }
      }
      
      $query .= " limit 20 offset = '$($_POST[page] * 20)'";
      
      $result = $sql -> query($query);
      
      $json = [];
      
      if ( $result -> num_rows() > 0 ) {
         while ( $row = $result -> fetch_array() ) {
            array_push($json, [
               "name" => $row["name"],
               "author" => $row["author"],
               "category" => $row["category"],
               "downloads" => $row["downloads"],
               "views" => $row["views"]
            ]);
         }
      }
      $result -> free_result();
      
      echo json_encode($jon);
   }
?>