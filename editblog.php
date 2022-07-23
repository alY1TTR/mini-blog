<?php
   include "config/base_url.php";
   include "config/db.php";

   if(isset($_GET["id"])){
      $id = $_GET["id"];
      $query = mysqli_query($con, "SELECT * FROM blogs WHERE id=$id");
      if(mysqli_num_rows($query)>0){
         $row = mysqli_fetch_assoc($query);
      }
   }
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Adding new blog</title>
   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

   <link rel="stylesheet" href="style/all.css">
</head>
<body>
   <main class="newblog-main">
      <div class="main-inner">
      <h1 class="newblog-title-d">Редактировать блог</h1>

      <form class="newblog-form" action="api/blog/update.php?id=<?=$id?>" method="POST" enctype="multipart/form-data">
         <fieldset class="newblog-field">
				<input class="newblog-title" type="text" name="title" placeholder="Заголовок">
			</fieldset>

         <fieldset>
            <div class="newblog-select">
               <select name="category_id" id="" class="newblog-select">
                  <?php
                     $query_cat = mysqli_query($con, "SELECT * FROM category");
                     while($cat = mysqli_fetch_assoc($query_cat)){
                        if($row["category_id"] == $cat["id"]){
                  ?>
                     <option disabled selected value="<?=$cat["id"]?>"><?=$cat["name"]?></option>
                  <?php        
                        }else{
                  ?>
                     <option value="<?=$cat["id"]?>"><?=$cat["name"]?></option>
                  <?php
                        }
                     }
                  ?>      
               </select>
            </div>
         </fieldset>

         <fieldset>
					<input class="newblog-fileinput" type="file" name="newblog-file-btn-img" placeholder="Выберите картину">	
			</fieldset>

         <fieldset>
				<textarea class="newblog-textarea" name="description" id="" cols="57" rows="10" placeholder="Описание"></textarea>
			</fieldset>
			<fieldset>
				<button class="newblog-save-button" type="submit">Сохранить</button>
			</fieldset>
      </form>
   </div>
   </main>   
</body>
</html>