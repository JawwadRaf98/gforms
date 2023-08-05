<?php
include_once './config.php';

$msg = '';
$success = 0;

if (isset($_SESSION['userLogin']) && $_SESSION['userLogin'] == true) {
    header('Location: index.php');
}

if (
    isset($_SESSION['signupToken']) &&
    @$_SESSION['signupToken'] == @$_POST['token']
) {
    // login Fucntionality;
    $user = $_POST['username'];
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $cpass = $_POST['cpassword'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $msg = 'Invalid email format';
    } elseif ($pass !== $cpass) {
        $msg = 'Password not match.';
    } else {
        $password = base64_encode($pass);
        //            $passw/ord = md5($pass);

        $sql = "SELECT * FROM `user` WHERE `email` = '$email'";
        $res = getRow($sql);
        if ($res !== false) {
            $msg = 'User already exist.';
        } else {
            $sql = "INSERT INTO `user`
                (`name`, `email`, `password`, `type`) 
                VALUES ('$user','$email','$password',1)";

            echo $res = setRow($sql);
            if ($res > 0) {
                $msg = 'Signup successfully.';
                $success = 1;
            } else {
                $msg = 'Signup failed.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./css/style.css">
  <title>SignUp Form</title>
  
</head>
<body>
  
  <div class="login-container">
    <h2>Signup</h2>

    <?php if (!empty($msg)) {
        $temp = $success == 1 ? 'success' : 'danger';
        echo '
          <div class="custom-alert ' .
            $temp .
            '" role="alert">
            ' .
            $msg .
            '
          </div>
        ';
    } ?>

    <form method = "POST">
        <?php
        $token = rand();
        $_SESSION['signupToken'] = $token;
        echo '<input type="hidden" name="token" value="' . $token . '" />';
        ?>
      <div class="form-group">
        <label for="username">Userame:</label>
        <input type="text" id="username" name="username" placeholder="Enter your username" required>
      </div>
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" placeholder="Enter your email" required>
      </div>
      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" placeholder="Enter your password" required>
      </div>
      <div class="form-group">
        <label for="cpassword">Password:</label>
        <input type="password" id="cpassword" name="cpassword" placeholder="Confirm password" required>
      </div>
      <div class="form-group">
        <button type="submit">Signup</button>
      </div>
      
    </form>
    <p><a href="login.php">Already had an account?</a></p>

  </div>
</body>
</html>
