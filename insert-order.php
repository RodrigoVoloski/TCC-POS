<?php 
//Include
include 'session.php';

//Get Connect to DataBase
$conn = getConnection();
$valueFinal = 0;
$orderId = 0;

//Total Calculated
$valueFinal = $_POST['total'];

//Insert Last Codes
$qryInsertLastCodes = "insert into ultimoscodigos values (:codigo, :codigoempresa)";
$stmt = $conn->prepare($qryInsertLastCodes); 
$stmt->bindValue(':codigo', '');
$stmt->bindValue(':codigoempresa', '1');

if ($stmt->execute()) {
  //Select Last Code
  $qrySelectLastCode = "select atendimento 
                          from ultimoscodigos 
                          order by atendimento desc 
                          limit 1";
  $stmt = $conn->prepare($qrySelectLastCode); 
  $stmt->execute();   
  $result = $stmt->fetchAll();

  foreach ($result as $value) {
    $orderId =  $value['atendimento'];
  } 

  //Insert Order
  $qryOrder = 'insert into pedidos (codigo, codigocolaborador, documento, datacadastro, horacadastro, subtotal, status, operacao, valortotal)
                            values (:codigo, :codigocolaborador, :documento, curdate(), curtime(), :subtotal, :status, :operacao, :valortotal)';
  $stmt = $conn->prepare($qryOrder); 
  $stmt->bindValue(':codigo', (string) $orderId);
  $stmt->bindValue(':codigocolaborador', $_SESSION['userId']);
  $stmt->bindValue(':documento', 'Pedido');
  $stmt->bindValue(':subtotal', $valueFinal);
  $stmt->bindValue(':status', 'Não Faturado');
  $stmt->bindValue(':operacao', 'Venda');
  $stmt->bindValue(':valortotal', $valueFinal);
  
  if ($stmt->execute()) {
    //Select Cart & Insert OrderItems
    $qryInsertOrderItens = 'insert into itenspedido (codigo, atendimento, codigoproduto, quantidade, totalcomdesconto)
                                             values (:codigo, :atendimento, :codigoproduto, :quantidade, :totalcomdesconto)';
    
    $qryDeleteCart = 'delete from carrinho where codigo = :codigo'; 

    $qrySelectCart = 'select * from carrinho where codigocolaborador = :codigocolaborador';                                
    $stmt = $conn->prepare($qrySelectCart);  
    $stmt->bindValue(':codigocolaborador', $_SESSION['userId']);    
    $stmt->execute(); 
    $result = $stmt->fetchAll();

    //Insert Items
    foreach ($result as $value) {
      $stmt = $conn->prepare($qryInsertOrderItens);
      $stmt->bindValue(':codigo', '');
      $stmt->bindValue(':atendimento', $orderId);
      $stmt->bindValue(':codigoproduto', $value['codigoproduto']);
      $stmt->bindValue(':quantidade', $value['quantidade']);
      $stmt->bindValue(':totalcomdesconto', $total);
      if ($stmt->execute()) {
         //Delete Cart Item
         $stmt = $conn->prepare($qryDeleteCart); 
         $stmt->bindValue(':codigo', $value['codigo']);
         $stmt->execute();
      } else {
        echo "<script>window.location='cart.php?iped=1;</script>";
      }
    }

    //Order Success
    echo "<script>window.location='product.php?success=1';</script>";
  } 
  else {
    echo "<script>window.location='cart.php?ped=1';</script>";
  }
} else {
  echo "<script>window.location='cart.php?ucode=1';</script>";
}
?>