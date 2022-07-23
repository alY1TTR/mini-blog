<?php
   include "../../config/base_url.php";
   include "../../config/db.php";

   if(isset($_POST["title"], $_POST["description"], $_POST["category_id"], $_GET["id"]) &&
      strlen($_POST["title"]) > 0 &&
      strlen($_POST["description"]) > 0 &&
      intval($_POST["category_id"]) &&
      intval($_GET["id"])
   ){
      $title = $_POST["title"];
      $desc = $_POST["description"];
      $cat_id = $_POST["category_id"];
      $id = $_GET["id"];
      session_start();
      $prep = mysqli_prepare($con, "UPDATE blogs SET title=?, description=?, category_id = ? WHERE id=? AND author_id =?");
      mysqli_stmt_bind_param($prep, "ssiii", $title, $desc, $cat_id, $id, $_SESSION["user_id"]);
      mysqli_stmt_execute($prep);

      header("Location: $BASE_URL/profile.php?nickname=".$_SESSION["nickname"]);
   }else{
      header("Location: $BASE_URL/editblog.php?error=11");
   }
?>


