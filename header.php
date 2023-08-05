<?php
    include_once('./config.php');
    include_once('./includes/auth.php');
    login_auth();
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forms</title>
    <link rel="stylesheet"  href="./css/style.css?magic=<?php echo rand();?>" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://kit.fontawesome.com/a16440b640.js" crossorigin="anonymous"></script>

</head>
<body>
    <header>
    <navbar>
        <div class="nav">
            <div class="logo">
                
            </div>
            <div class="nav-links">
                <ul>
                    <li>
                        <a href="index.php">Home</a>
                    </li>
                    <li>
                        <a href="add_form.php?magic=<?php echo rand();?>">Add From</a>
                    </li>
                    <?php
                        if(isset($_SESSION['userLogin'] ) && $_SESSION['userLogin'] == true){
                            echo '
                            <li>
                                <a href="logout.php">Logout</a>
                            </li>
                            ';
                        }else{
                            echo ' <li>
                                <a href="login.php">Login/SignUp</a>
                            </li>
                            ';
                        }
                        ?>
                  
                   
                    
                </ul>
            </div>
        </div>
    </navbar>
    </header>