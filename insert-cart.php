<?php
//Include
include 'session.php';

//Get Connect to DataBase
$conn = getConnection();
$codeproduct = $_POST["code"];
$count = 0;
$fullQuantity = 0;

//Verify Quantity
if ((isset($_POST["qtd"])) && (!$_POST["qtd"]=="")) {
    $quantity = $_POST["qtd"];

    //Search full quantity cart
    $qrySelectQuantity = 'select sum(quantidade) fullquantity from carrinho where codigoproduto = :codigoproduto';
    $stmt = $conn->prepare($qrySelectQuantity);
    $stmt->bindValue(':codigoproduto', $codeproduct);
    $stmt->execute();
    $result = $stmt->fetchAll();

    foreach ($result as $value) {
        $fullQuantity = $value['fullquantity'];
    }

    $fullQuantity = $fullQuantity + $quantity; 

    //Verify Avaliable Stock
    $qryVerifyStock = 'select estoquedisponivel from produto where codigo = :codigoproduto';
    $stmt = $conn->prepare($qryVerifyStock);
    $stmt->bindValue(':codigoproduto', $codeproduct);
    $stmt->execute();
    $result = $stmt->fetchAll();

    foreach ($result as $value) {
        $avaliableStock = $value['estoquedisponivel'];
    }

    //Insert to Cart
    if ($fullQuantity > $avaliableStock) {
        echo "<script>window.location='product.php?qtdmax=1';</script>";  
    } else {
        $qrySelectProduct = 'select count(*) count from carrinho where codigoproduto = :codigoproduto and codigocolaborador = :codigocolaborador ';
        $stmt = $conn->prepare($qrySelectProduct);
        $stmt->bindValue(':codigoproduto', $codeproduct);
        $stmt->bindValue(':codigocolaborador', $_SESSION['userId']);
        $stmt->execute();
        $result = $stmt->fetchAll();

        foreach ($result as $value) {
            $count = $value['count'];
        }

        if ($count == 0){
            $qryInsertCart = 'insert into carrinho values (:codigo, :colaborador, :quantidade, :produto)';

            $stmt = $conn->prepare($qryInsertCart);
            $stmt->bindValue(':codigo', '');
            $stmt->bindValue(':colaborador', $_SESSION['userId']);
            $stmt->bindValue(':quantidade', $quantity);
            $stmt->bindValue(':produto', $codeproduct);

            if($stmt->execute()) {
                header("Location: cart.php");
            } else {
                echo "<script>window.location='product.php?erro=1';</script>";
            }
        } else {
            //Search code and quantity of cart
            $qrySelectQuantity = 'select codigo, quantidade from carrinho where codigoproduto = :codigoproduto and codigocolaborador = :codigocolaborador';
            $stmt = $conn->prepare($qrySelectQuantity);
            $stmt->bindValue(':codigoproduto', $codeproduct);
            $stmt->bindValue(':codigocolaborador', $_SESSION['userId']);
            $stmt->execute();
            $result = $stmt->fetchAll();

            foreach ($result as $value) {
                $codeCart = $value['codigo']; 
                $oldQuantity = $value['quantidade'];
            }
            
            //Sum new quantity
            $newQuantity = $oldQuantity + $quantity;

            //Update new quantity
            $qryUpdateProduct = 'update carrinho set quantidade = :quantidade where codigo = :codigo';
            $stmt = $conn->prepare($qryUpdateProduct);
            $stmt->bindValue(':quantidade', $newQuantity);
            $stmt->bindValue(':codigo', $codeCart);
            if($stmt->execute()) {
                header("Location: cart.php");
            } else {
                echo "<script>window.location='product.php?er=1';</script>";
            }
        }
    }
} else {
    echo "<script>window.location='product.php?qtd=1';</script>";
}
?>