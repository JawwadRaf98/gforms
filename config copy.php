<?php 
    session_start();

    $web_url = "https://imhostings.com/e/v";
   
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

    function getRow($query) {
        try {
            $pdo = connectToDatabase();
            $stmt = $pdo->prepare($query);
            // $stmt->bindParam(':conditionValue', $conditionValue);
            $stmt->execute();
            $response = $stmt->fetch(PDO::FETCH_ASSOC);
            // if(!empty($response)){
            //     $response =  $response[0];
            // }else{
            //     $response = array();
            // }
            return $response;
        } catch (PDOException $e) {
            die("Error executing query: " . $e->getMessage());
        }
    } 
    
    function getRows($query) {
        try {
            $pdo = connectToDatabase();
            $stmt = $pdo->prepare($query);
            // $stmt->bindParam(':conditionValue', $conditionValue);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Error executing query: " . $e->getMessage());
        }
    }
    
    function setRow($query) {
        $pdo = connectToDatabase();
        try {
            $stmt = $pdo->prepare($query);
            $stmt->execute(@$data);
            $affectedRows = $stmt->rowCount();
            if ($affectedRows > 0) {
                // If the update was successful, return the user ID
                return $affectedRows;
            } else {
                return 0;
            }
            // Get the last inserted row ID
            $lastInsertedId = $pdo->lastInsertId();
            
            return $lastInsertedId;
        } catch (PDOException $e) {
            die("Error executing query: " . $e->getMessage());
    }
}

?>
