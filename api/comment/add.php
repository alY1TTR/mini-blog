<?php
   include "../../config/db.php";
   include "../../config/base_url.php";

   $data = json_decode(file_get_contents('php://input'), true);

   if(isset($data["text"], $data["author_id"], $data["blog_id"]) &&
   strlen($data["text"]) > 0 &&
   intval($data["blog_id"]) &&
   intval($data["author_id"])
   ){ 
      $text = $data["text"];
      $blog_id = $data["blog_id"];
      $author_id = $data["author_id"];

      $prep = mysqli_prepare($con, "INSERT INTO comments (text, blog_id, author_id) VALUES(?, ?, ?)");
      mysqli_stmt_bind_param($prep, "sii", $text, $blog_id, $author_id);
      mysqli_execute($prep);  

      $id = mysqli_stmt_insert_id($prep); 
      $q_c = mysqli_query($con, "SELECT c.*, u.full_name FROM comments c LEFT OUTER JOIN users u ON c.author_id = u.id WHERE c.blog_id=$id");

      if(mysqli_num_rows($q_c) > 0){
         $row = mysqli_fetch_assoc($q_c);
         json_encode($row);
      }
   }else{
      echo "error";
   }

?>