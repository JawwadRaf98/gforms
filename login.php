<?php
    include_once('./config.php');

    if(isset( $_SESSION["userLogin"]) &&  $_SESSION["userLogin"] == true){
        header('Location: index.php');
    }

    // var_dump($_SESSION['loginToken'],$_POST['token']);
    if(isset($_SESSION['loginToken']) && $_SESSION['loginToken'] == $_POST['token']){
        // login Fucntionality;
        $user = $_POST['username'];
        $password = $_POST['password'];

        $res = 1;
        if($res > 0){
            $_SESSION["userLogin"] = true;
            header("Location: index.php");  
        }

        // set Session


    }


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./css/style.css">
  <title>Login Form</title>
  
</head>
<body>
  <div class="login-container">
    <h2>Login Form</h2>
    <form method = "POST">
        <?php
            $token = rand();
            $_SESSION['loginToken']=$token;
            echo '<input type="hidden" name="token" value="'.$token.'" />';
        ?>
      <div class="form-group">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" placeholder="Enter your username" required>
      </div>
      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" placeholder="Enter your password" required>
      </div>
      <div class="form-group">
        <button type="submit">Login</button>
      </div>
    </form>
  </div>
</body>
</html>
