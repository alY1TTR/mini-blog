<?php
   include "config/base_url.php";
   include "config/db.php";
   include "common/totimeago.php";
   include "session/session.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Profile</title>
   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

   <link rel="stylesheet" href="style/all.css">
</head>
<body>
   <main class="profile-main">
      <div class="person-info">
         <div class="person-info-img">
            <img src="img/blogs/traveller_img.jpg" alt="">
         </div>
         <div class="person-info-info">
            <h2>Adam Johns</h2>
            <p>Я веду блог по путешествиям и хочу делиться с вами моими выходами. Вы можете узнать много нового о природе, если будете следить за моими блогами.</p>
            <a class="move-out" href="api/user/signout.php">Выход</a>
            <a class="move-main" href="index.php">На главную</a>
         </div>
      </div>

      <div class="profile-des">
         <h3>My Blogs</h3>
         <a href="newblog.php" class="adding-from-profle">New Blog</a>
      </div>

      <?php
         $query = mysqli_prepare($con, "SELECT b.*, c.name, u.nickname FROM blogs b LEFT OUTER JOIN category c ON b.category_id = c.id LEFT OUTER JOIN users u ON b.author_id = u.id WHERE u.nickname =?");
         mysqli_stmt_bind_param($query, "s", $_GET["nickname"]);
         mysqli_stmt_execute($query);
         $prep = mysqli_stmt_get_result($query);
         if(mysqli_num_rows($prep) > 0){
            while($row = mysqli_fetch_assoc($prep)){
          
      ?> 
         <div class="index-blogs-articles-item profile-article">
            <div class="index-blogs-articles-item-inner">
               <div class="articles-inner-text">
                  <div class="time-ago">
                     <img src="img/blogs/clock.svg" alt="">
                     <p class="article-time"><?= to_time_ago(strtotime($row["date"])) ?></p>
                     <div class="article-cat-choice">
                        <img src="img/blogs/category_article.svg" alt="">
                        <p><?=$row["name"]?></p>
                     </div>
                  </div>
                  <h2><?=$row["title"]?></h2>
                  <p class="article-text"><?=$row["description"]?></p>
                  <div class="article-author">
                     <img src="img/blogs/user.svg" alt="">
                     <a href=""><?=$row["nickname"]?></a>
                  </div>
               </div>

               <div class="article-inner-img">
                  <img src="<?=$BASE_URL?>/<?=$row["img"]?>" alt="">
               </div>
            </div>
         </div>

         <?php
            // session_start();
            if($row["author_id"] == $_SESSION["user_id"]){
         ?>
            <div class="edit-button">
               <a href="<?=$BASE_URL?>/editblog.php?id=<?=$row["id"]?>" class="edit">Редактировать</a>
            </div>
            <div class="delete-btn">
               <a href="<?=$BASE_URL?>/api/blog/delete.php?id=<?=$row["id"]?>" class="blog-delete">Удалить</a>
            </div>
         <?php
            }else{
         ?>
            <div></div>
         <?php
            }
         ?>

      <?php    
            }
         }else{
         ?>
            <h1 class="profile-n-blog">There is no blogs</h1>
         <?php
         }
      ?>
   </main>
</body>
</html>