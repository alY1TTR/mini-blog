<?php
   include "config/base_url.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Register Page</title>
   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

   <link rel="stylesheet" href="style/all.css">
</head>
<body class="register-body">
   <main class="register-main">
      <img class="register-logo" src="img/blogs/Gallivant.png" alt="">
      <form class="login-btn" action="" method="post">
         <fieldset>
            <button type="submit">Login</button>
         </fieldset>
      </form>
      <h1>Register</h1> 
      <form class="registering-form" action="<?=$BASE_URL?>/api/user/signup.php" method="POST">
         <fieldset class="fieldset">
            <input class="input" type="text" name="email" placeholder="Введите email">
        </fieldset>
        <fieldset class="fieldset">
            <input class="input" type="text" name="full_name" placeholder="Полное имя">
        </fieldset>
        <fieldset class="fieldset">
            <input class="input" type="text" name="nickname" placeholder="Nickname">
        </fieldset>
        <fieldset class="fieldset">
            <input class="input" type="password" name="password" placeholder="Введите пароль">
        </fieldset>
        <fieldset class="fieldset">
            <input class="input" type="password" name="password2" placeholder="Подтвердить пароль">
        </fieldset>

        <fieldset class="fieldset">
            <button class="button" type="submit">Зарегистрироваться</button>
        </fieldset>
      </form> 
   </main>
</body>
</html>