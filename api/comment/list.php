<?php
   include "../../config/db.php";
   include "../../config/base_url.php";

   if(!isset($_GET["id"]) || !intval($_GET["id"])){
      exit();
   }

   $id = $_GET["id"];

   $query_comments = mysqli_query($con, "SELECT c.*, u.full_name FROM comments c LEFT OUTER JOIN users u ON c.author_id = u.id WHERE c.blog_id=$id");
   $comments = array();

   if(mysqli_num_rows($query_comments) == 0){
      echo json_encode($comments);
      exit();
   }

   while($comment = mysqli_fetch_assoc($query_comments)){
      $comments[] = $comment;
   }

   echo json_encode($comments);

?>