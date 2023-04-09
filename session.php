<?php 
//Session
session_start();

//Includes
include 'connection.php';

//Declare Variables
$countLogin = 0;
$connect = getConnection();

//Login Process

if (isset($_POST['submit'])) {
    $user = $_POST["user"];
    $password = $_POST["password"];

    //Select Query
    $qryLogin = 'select count(*) counter from colaborador where cpfcnpj = :user and senha = :password';

    // Validate Login
    $stmt = $connect->prepare($qryLogin); 
    $stmt->bindValue(':user', $user);
    $stmt->bindValue(':password', $password);
    $stmt->execute();
    $result = $stmt->fetchAll();

    foreach ($result as $value){
        $countLogin = $value['counter']; 
    }

    if ($countLogin > 0) {
        //Get User and Permissions
        $qryUserName = 'select nomerazaosocial, tipo, codigo from colaborador where cpfcnpj = :user and senha = :password';
        $stmt = $connect->prepare($qryUserName); 
        $stmt->bindValue(':user', $user);
        $stmt->bindValue(':password', $password);
        $stmt->execute();
        $result = $stmt->fetchAll();

        foreach ($result as $value){
            $username = $value['nomerazaosocial']; 
            $typePermission = $value['tipo'];
            $userId = $value['codigo'];
        }

        //Verify Table Prices
        $qryPracticed = 'select praticadopadrao 
                        from colaborador c inner join tabeladeprecos t on c.tabelapadrao = t.nometabela
                        where c.codigo = :codigocolaborador';
        $stmt = $connect->prepare($qryPracticed); 
        $stmt->bindValue(':codigocolaborador', $userId);
        $stmt->execute();
        $result = $stmt->fetchAll();

        foreach ($result as $value){
            $practiced = $value['praticadopadrao']; 
        }

        //Get Informations 
        $_SESSION['username'] = $username;
        $_SESSION['typePermission'] = $typePermission;
        $_SESSION['userId'] = $userId; 
        $_SESSION['practiced'] = $practiced;
        
        //Locate Home Page
        header("Location: product.php");
    } else {
        echo "<script>window.location='index.php?erro=1';</script>";  
    }
}
?>