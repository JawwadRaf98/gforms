<?php
    function login_auth(){
        if(!isset( $_SESSION["userLogin"]) ||  $_SESSION["userLogin"] == false){
            header('Location: login.php');
        }
    }
    

?>