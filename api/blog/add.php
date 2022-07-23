<?php
   include "../../config/db.php";
   include "../../config/base_url.php";

   if(isset($_POST["title"], $_POST["description"], $_POST["category_id"]) && 
   strlen($_POST["title"]) > 0 && 
   strlen($_POST["description"]) > 0 &&
   intval($_POST["category_id"])
   ){
      session_start();
      $title = $_POST["title"];
      $desc = $_POST["description"];
      $cat_id = $_POST["category_id"];
      $author_id = $_SESSION["user_id"];

      if(isset($_FILES["newblog-file-btn-img"], $_FILES["newblog-file-btn-img"]["name"]) &&
      strlen($_FILES["newblog-file-btn-img"]["name"]) > 0
      ){
         $ext = end(explode(".", $_FILES["newblog-file-btn-img"]["name"]));
         $image_name = time().".".$ext;

         move_uploaded_file($_FILES["newblog-file-btn-img"]["tmp_name"], "../../img/blogs/$image_name" );

         $path = "img/blogs/".$image_name;
         $prep = mysqli_prepare($con, "INSERT INTO blogs (title, description, img, category_id, author_id) VALUES (?, ?, ?, ?, ?)");
         mysqli_stmt_bind_param($prep, "sssii", $title, $desc, $path, $cat_id, $author_id);
         mysqli_stmt_execute($prep);

      }else{
         $prep = mysqli_prepare($con, "INSERT INTO blogs (title, description, category_id, author_id) VALUES (?, ?, ?, ?)");
         mysqli_stmt_bind_param($prep, "ssii", $title, $desc, $cat_id, $author_id);
         mysqli_stmt_execute($prep);
      }
 



      header("Location: $BASE_URL/index.php");
   }else{
      header("Location: $BASE_URL/newblog.php?error=1");
   }
?>