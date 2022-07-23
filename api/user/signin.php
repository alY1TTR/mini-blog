<?php
   include "../../config/db.php";
   include "../../config/base_url.php";

   if(isset($_POST["email"],$_POST["password"]) && 
   strlen($_POST["email"]) > 0 && 
   strlen($_POST["password"]) > 0 
   ){
      $email = $_POST["email"];
      $password = $_POST["password"];


      $prep = mysqli_prepare($con, "SELECT id, nickname FROM users WHERE email=? AND password=?");
      mysqli_stmt_bind_param($prep, "ss", $email, $password);
      mysqli_stmt_execute($prep);
      $query = mysqli_stmt_get_result($prep);

      if(mysqli_num_rows($query) == 0){
         header("Location: $BASE_URL/login.php?error=9");
         exit();
      }

      $row = mysqli_fetch_assoc($query);

      session_start();

      $_SESSION["user_id"] = $row["id"];
      $_SESSION["nickname"] = $row["nickname"];

      header("Location: $BASE_URL/profile.php?nickname=".$_SESSION["nickname"]);

      
   }else{
      header("Location: $BASE_URL/login.php?error=10");
   }
?>