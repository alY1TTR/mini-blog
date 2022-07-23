<?php
    include "config/base_url.php";
    include "config/db.php";
    include "common/totimeago.php";

    if(!isset($_GET["id"]) || !intval($_GET["id"])){
      header("Location:$BASE_URL/index.php");
      exit();
    }

    $id = $_GET["id"];
    $querry_blog = mysqli_query($con, "SELECT b.*, c.name, u.nickname FROM blogs b LEFT OUTER JOIN category c ON b.category_id = c.id LEFT OUTER JOIN users u ON b.author_id = u.id WHERE b.id = $id");
    if(mysqli_num_rows($querry_blog) == 0){
      header("Location:$BASE_URL/index.php?error=15");
      exit();
    }

    $blog = mysqli_fetch_assoc($querry_blog);
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Комментарий</title>
   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

   <link rel="stylesheet" href="style/all.css">
</head>
<body data-baseurl="<?=$BASE_URL?>" data-authorid = "<?=$blog["author_id"]?>" class="comment-bod">
   <div class="goback-from-com">
      <a href="index.php" class="goback">На главную</a>
   </div>
   <div class="index-blogs-articles-item">
      <div class="index-blogs-articles-item-inner">
         <div class="articles-inner-text">
            <div class="time-ago">
               <img src="img/blogs/clock.svg" alt="">
               <p class="article-time"><?= to_time_ago(strtotime($blog["date"]))?></p>
               <div class="article-cat-choice">
                  <img src="img/blogs/category_article.svg" alt="">
                  <p><?=$blog["name"]?></p>
               </div>
            </div>
            <h2><?=$blog["title"]?></h2>
            <p class="article-text"><?=$blog["description"]?></p>
            <div class="article-author">
               <img src="img/blogs/user.svg" alt="">
               <a href=""><?=$blog["nickname"]?></a>
            </div>
         </div>

         <div class="article-inner-img">
            <img src="<?=$blog["img"]?>" alt="">
         </div>
      </div>
   </div>

   <div id="comments" class="commen_blog"></div>

   <?php
      if(isset($_SESSION["user_id"])){
   ?>

   <div class="login-warning">
      <p>Чтобы оставить комментарий <a href="<?=$BASE_URL?>/register.php">Зарегистрируйтесь</a>, или <a href="<?=$BASE_URL?>/login.php">войдите</a> в аккаунт</p>
   </div>
   <?php
      }else{
   ?>

   <div class="textarea-btn">
      <textarea class="add-com-textarea" placeholder="Введите комментарий" name="" id="textarea" cols="70" rows="15"></textarea>
      <div class="com-send-btn">
         <button id="add-comment">Отправить</button>
      </div>
   </div>
   <?php
      }
   ?>

   <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.26.0/axios.min.js" integrity="sha512-bPh3uwgU5qEMipS/VOmRqynnMXGGSRv+72H/N260MQeXZIK4PG48401Bsby9Nq5P5fz7hy5UGNmC/W1Z51h2GQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
   <script src="js/comment.js"></script>
</body>
</html>


