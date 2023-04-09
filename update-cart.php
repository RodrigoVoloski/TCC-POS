<?php
include "session.php";
$conn = getConnection();
$fullQuantity = 0;

if ( (isset($_POST["qtd"])) && (!$_POST["qtd"]=="") ) {
    $quantity = $_POST["qtd"];
    $code = $_POST["code"];
    $codeProd = $_POST["codeprod"];

    //Search full quantity cart
    $qrySelectQuantity = 'select sum(quantidade) fullquantity from carrinho where codigoproduto = :codigoproduto';
    $stmt = $conn->prepare($qrySelectQuantity);
    $stmt->bindValue(':codigoproduto', $codeProd);
    $stmt->execute();
    $result = $stmt->fetchAll();

    foreach ($result as $value) {
        $fullQuantity = $value['fullquantity'];
    }

    //Search old quantity cart
    $qrySelectQuantity = 'select quantidade from carrinho where codigo = :codigo';
    $stmt = $conn->prepare($qrySelectQuantity);
    $stmt->bindValue(':codigo', $code);
    $stmt->execute();
    $result = $stmt->fetchAll();

    foreach ($result as $value) {
        $oldQuantity = $value['quantidade'];
    }

    $fullQuantity = ($fullQuantity + $quantity) - $oldQuantity;
    
    //Verify Stock
    $qryVerifyStock = 'select estoquedisponivel from produto where codigo = :codigo';
    $stmt = $conn->prepare($qryVerifyStock);
    $stmt->bindValue(':codigo', $codeProd);
    $stmt->execute();
    $result = $stmt->fetchAll();

    foreach ($result as $value) {
        $avaliableStock = $value['estoquedisponivel'];
    }

    if ($fullQuantity <= $avaliableStock){
        $qryEditCart = 'update carrinho set quantidade = :quantidade where codigo = :codigo';
        $stmt = $conn->prepare($qryEditCart);
        $stmt->bindValue(':quantidade', $quantity);
        $stmt->bindValue(':codigo', $code);
    
        if($stmt->execute()){
            header("Location: cart.php");
        }else{
            echo "<script>window.location='productview.php?erroed=1';</script>";
        }
    } else {
        echo "<script>window.location='cart.php?qtdr=1';</script>";
    }
    
} else {
    echo "<script>window.location='cart.php?qtd=1';</script>";
}
?>