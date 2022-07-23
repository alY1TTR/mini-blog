<?php
   include "config/db.php";
   include "common/totimeago.php";
   include "config/base_url.php";

   $sql = "SELECT b.*, c.name, u.nickname FROM blogs b LEFT OUTER JOIN category c ON b.category_id = c.id LEFT OUTER JOIN users u ON b.author_id = u.id";
   $search = "";

   if(isset($_GET["category_id"]) && intval($_GET["category_id"])){
      $sql .= " WHERE b.category_id=".$_GET["category_id"];
   }
   if(isset($_GET["search"]) && strlen($_GET["search"])){
      $search = strtolower($_GET["search"]);
      $sql .= " WHERE LOWER(b.title) LIKE ? OR LOWER(b.description) LIKE ? OR LOWER(u.nickname) LIKE ? OR LOWER(c.name) LIKE ?";
   }

   if($search){
		$q = "%$search%";
		$search_prep = mysqli_prepare($con, $sql);
		mysqli_stmt_bind_param($search_prep, "ssss", $q, $q, $q, $q);	
		mysqli_stmt_execute($search_prep); 
		$query = mysqli_stmt_get_result($search_prep);
	}else{
		$query = mysqli_query($con, $sql);
	}

?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Main page</title>
   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

   <link rel="stylesheet" href="style/all.css">

   <link rel="stylesheet" type="text/css" href="slick/slick.css"/>

   <link rel="stylesheet" type="text/css" href="slick/slick-theme.css"/>
</head>
<body>
   <section class="header-main">
      <header class="index_header">
         <div class="logo-img">
            <img src="img/blogs/Gallivant (2).png" alt="">
         </div>
         <div class="main-page-search">
            <form class="index_form" method="GET" action="">
               <fieldset class="index-search">
                  <input name="search" type="text" name="index-search" placeholder="Поиск по блогам">
                  <button type="submit">Найти</button>
               </fieldset>
            </form>
         </div>

         <?php
         session_start();
            if(isset($_SESSION["user_id"])) {
         ?>
            <div class="prof-img">
               <a href="profile.php?nickname=<?=$_SESSION["nickname"]?>"><img src="img/blogs/person_avatar.png" alt=""></a>
            </div>
         <?php
            }else{
         ?>

            <div class="button-group">
               <a href="register.php">Регистрация</a>
               <a href="login.php">Вход</a>
            </div>
         <?php
            }
         ?>
      </header>

      <main class="index-main">
         <h1>Where will you go next?</h1>
         <p>PS I'm On My Way. Apart from a great name, PS I'm On My Way boasts a fun, exciting, and action-packed travel blog. ... </p>
      </main>
   </section>

   <div class="index-categories">
      <h2>Choose a category</h2>
      <div class="category-slides">

<?php
   $query_cat = mysqli_query($con, "SELECT * FROM category");
   while($category = mysqli_fetch_assoc($query_cat)){
?>
   <div class="category-slides-item cat1">
            <a href="?category_id=<?=$category["id"]?>"><?=$category["name"]?></a>
         </div>
<?php
   }
?>
         <!-- <div class="category-slides-item cat1">
            <a>Solo Travel</a>
         </div>
         <div class="category-slides-item cat2">
            <a>Solo Travel</a>
         </div>
         <div class="category-slides-item cat3">
            <a>Solo Travel</a>
         </div>
         <div class="category-slides-item cat4">
            <a>Solo Travel</a>
         </div>
         <div class="category-slides-item cat5">
            <a>Solo Travel</a>
         </div>
         <div class="category-slides-item cat6">
            <a>Solo Travel</a>
         </div>
         <div class="category-slides-item cat7">
            <a>Solo Travel</a>
         </div>
         <div class="category-slides-item cat8">
            <a>Solo Travel</a>
         </div> -->
         
      </div>
   </div>

   <div class="index-blogs-title">
      <h2>Blogs about Travel</h2>
      <p>Interesting and fresh blogs related to travel and world exploration</p>
   </div>

   <div class="index-blogs-articles">
      <?php
         
         if(mysqli_num_rows($query) > 0){
            while($row = mysqli_fetch_assoc($query)){
      ?>
            <div class="index-blogs-articles-item">
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
               <a class="commentss" href="<?=$BASE_URL?>/blog-details.php?id=<?=$row["id"]?>"><h2> <?= $row["title"]?> </h2></a>
               <p class="article-text"><?= $row["description"] ?></p>
               <div class="article-author">
                  <img src="img/blogs/user.svg" alt="">
                  <a href="profile.php?nickname=<?=$row["nickname"]?>"><?=$row["nickname"]?></a>
               </div>
            </div>

            <div class="article-inner-img">
               <img src="<?=$row["img"]?>" alt="">
            </div>
         </div>
      </div>
      <?php
            }
         }else{
      ?>
         <h2 class="cat-no-blog">No blogs for such category</h2>

      <?php
         }
      ?>
      

      <!-- <div class="index-blogs-articles-item">
         <div class="index-blogs-articles-item-inner">
            <div class="articles-inner-text">
               <div class="time-ago">
                  <img src="img/blogs/clock.svg" alt="">
                  <p class="article-time">August 13, 2021</p>
                  <div class="article-cat-choice">
                     <img src="img/blogs/category_article.svg" alt="">
                     <p>Hiking</p>
                  </div>
               </div>
               <h2>10 Hilarious Cartoons That Depict Real-Life Problems of Programmers</h2>
               <p class="article-text">Redefined the user acquisition and redesigned the onboarding experience, all within 3 working weeks.</p>
               <div class="article-author">
                  <img src="img/blogs/user.svg" alt="">
                  <a href="">User</a>
               </div>
            </div>

            <div class="article-inner-img">
               <img src="img/blogs/article_img.png" alt="">
            </div>
         </div>
      </div> -->

      <!-- <div class="index-blogs-articles-item">
         <div class="index-blogs-articles-item-inner">
            <div class="articles-inner-text">
               <div class="time-ago">
                  <img src="img/index/clock.svg" alt="">
                  <p class="article-time">August 13, 2021</p>
                  <div class="article-cat-choice">
                     <img src="img/index/category_article.svg" alt="">
                     <p>Hiking</p>
                  </div>
               </div>
               <h2>10 Hilarious Cartoons That Depict Real-Life Problems of Programmers</h2>
               <p class="article-text">Redefined the user acquisition and redesigned the onboarding experience, all within 3 working weeks.</p>
               <div class="article-author">
                  <img src="img/index/user.svg" alt="">
                  <a href="">User</a>
               </div>
            </div>

            <div class="article-inner-img">
               <img src="img/index/article_img.png" alt="">
            </div>
         </div>
      </div>

      <div class="index-blogs-articles-item">
         <div class="index-blogs-articles-item-inner">
            <div class="articles-inner-text">
               <div class="time-ago">
                  <img src="img/index/clock.svg" alt="">
                  <p class="article-time">August 13, 2021</p>
                  <div class="article-cat-choice">
                     <img src="img/index/category_article.svg" alt="">
                     <p>Hiking</p>
                  </div>
               </div>
               <h2>10 Hilarious Cartoons That Depict Real-Life Problems of Programmers</h2>
               <p class="article-text">Redefined the user acquisition and redesigned the onboarding experience, all within 3 working weeks.</p>
               <div class="article-author">
                  <img src="img/index/user.svg" alt="">
                  <a href="">User</a>
               </div>
            </div>

            <div class="article-inner-img">
               <img src="img/index/article_img.png" alt="">
            </div>
         </div>
      </div>  -->
      
   </div>


   <script src="https://code.jquery.com/jquery-migrate-3.3.2.min.js" integrity="sha256-Ap4KLoCf1rXb52q+i3p0k2vjBsmownyBTE1EqlRiMwA=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="slick/slick.min.js"></script>
   <script src="js/blog_slide.js"></script>
</body>
</html>