<?php
   include "config/base_url.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login Page</title>
   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

   <link rel="stylesheet" href="style/all.css">
</head>
<body class="login-body">
   <main class="login_main">
      <img class="login-logo" src="img/blogs/Gallivant (1).png" alt="">
      <h1>Sign in</h1>
      <form id="log_form" class="login_form" method="POST" action="<?=$BASE_URL?>/api/user/signin.php">
            <fieldset>
               <input id='p_log' type="text" tabindex="1" name="email" placeholder="Введите email">
            </fieldset>
            <fieldset>
               <input class="login-pass-ent" id='p_pass' type="password" tabindex="2" name="password" placeholder="Введите пароль">
            </fieldset>
            <fieldset>
               <button class="log-b" type="submit">Login</button>
            </fieldset>
      </form> 
   </main>
   <script src="js/login.js"></script>
   <script src="js/register.js"></script>
</body>
</html>