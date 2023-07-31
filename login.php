<?php
    include_once('./config.php');

    $msg = "";

    if(isset( $_SESSION["userLogin"]) &&  $_SESSION["userLogin"] == true){
        header('Location: index.php');
    }

    if(isset($_SESSION['loginToken']) && @$_SESSION['loginToken'] == @$_POST['token']){
        // login Fucntionality;
        $email = $_POST['email'];
        $password = $_POST['password'];
        $password = base64_encode($password);
        $password = md5($password);
        $sql = "SELECT * FROM `user` WHERE `email` = '$email' AND `password` = '$password'";
        $data = getRow($sql); 
        if($data !== false){
            $webuser = array('id'=>$data['id'], 'name'=>$data['name'], 'email'=>$data['email'], 'type'=>$data['type']);
            $_SESSION["userLogin"] = true;
            $_SESSION['webuser'] = $webuser;
            header("Location: index.php");  
        }else{
            $msg = "Invalid email or password";
        }
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

    <?php 
    if(!empty($msg)){
        echo '
          <div class="custom-alert danger" role="alert">
            '. $msg .'
          </div>
        ';
    }?>

    <form method = "POST">
        <?php
            $token = rand();
            $_SESSION['loginToken']=$token;
            echo '<input type="hidden" name="token" value="'.$token.'" />';
        ?>
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" placeholder="Enter your email" required>
      </div>
      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" placeholder="Enter your password" required>
        <!-- <small><a href="trouble.php">Forget password?</a></small> -->
      </div>
      <div class="form-group">
        <button type="submit">Login</button>
      </div>
    </form>
    <p><a href="signup.php">Creat an account/Signup</a></p>

  </div>
</body>
</html>
