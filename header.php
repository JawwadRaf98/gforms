<?php
    include_once('./config.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forms</title>
    <link rel="stylesheet"  href="./css/style.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
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
                        <a href="email_software_mail_new.php">Home</a>
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
                  
                    <li>
                        <a href="update_smtp.php?magic=<?php echo rand();?>">Add From</a>
                    </li>
                    
                </ul>
            </div>
        </div>
    </navbar>
    </header>