<?php
//Connect to DataBase
 function getConnection(){
    $dsn = 'mysql:dbname=desenvolvimento;host=localhost;charset=utf8';
    $user = 'root';
    $pass = 'senha';
    
    //Return PDO
        try {
            $pdo = new PDO($dsn, $user, $pass); 
            return $pdo;
        } catch (PDOException $ex) {
            echo 'Erro '.$ex->getMessage(); 
        }
    }          
?>
