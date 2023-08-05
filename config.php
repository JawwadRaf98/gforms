<?php 
    session_start();
    $web_url = "http://localhost/gforms";
//     ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
   
    define('WEB_URL',$web_url);
    
    
    function connectToDatabase() {
        try {
            
            $host = "localhost";
            $dbname = "gforms";
            $username = "root";
            $password = "";

            $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }
    
    // $pdo_ = connectToDatabase($host, $dbname, $username, $password);

    function getRow($query, $arr=null) {
        try {
            $pdo = connectToDatabase();
            $stmt = $pdo->prepare($query);
            if($arr==null){
                for($i=0;$i<$arr;$i++){
                    $index=$i+1;
                    $stmt->bindParam($index, $arr[$i]);
                }
            }else{
                for($i=0;$i<sizeof($arr);$i++){
                    $index=$i+1;
                    $stmt->bindParam($index, $arr[$i]);
                }
            }
            $stmt->execute();
            $response = $stmt->fetch(PDO::FETCH_ASSOC);
           
            return $response;
        } catch (PDOException $e) {
            die("Error executing query: " . $e->getMessage());
        }
    } 
    
    function getRows($query,$arr=null) {
        try {
            $pdo = connectToDatabase();
            $stmt = $pdo->prepare($query);
            if($arr==null){
                    for($i=0;$i<$arr;$i++){
                        $index=$i+1;
                        $stmt->bindParam($index, $arr[$i]);
                    }
              }else{
                    for($i=0;$i<sizeof($arr);$i++){
                        $index=$i+1;
                        $stmt->bindParam($index, $arr[$i]);
                    }
                }
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Error executing query: " . $e->getMessage());
        }
    }
    
    function setRow($query,$arr=null,$insert=true) {
        $pdo = connectToDatabase();
        try {
            $data = $stmt = $pdo->prepare($query);
            if($arr==null){
                    for($i=0;$i<$arr;$i++){
                        $index=$i+1;
                        $stmt->bindParam($index, $arr[$i]);
                    }
              }else{
                    for($i=0;$i<sizeof($arr);$i++){
                        $index=$i+1;
                        $stmt->bindParam($index, $arr[$i]);
                    }
                }
            $stmt->execute();
            $affectedRows = $stmt->rowCount();
            $lastInsertedId = $pdo->lastInsertId();
            if($affectedRows > 0) {
                if($insert){
                    return $lastInsertedId;
                }else{
                    return $affectedRows;
                }
            } else {
                return 0;
            }
            
        } catch (PDOException $e) {
            die("Error executing query: " . $e->getMessage());
    }
}

   

?>
