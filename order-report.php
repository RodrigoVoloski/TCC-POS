<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Voloski Revendedora</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>
<?php include 'session.php'; 
$conn = getConnection();
$countOrder = 0;

$qryCart = 'select count(*) countcart from carrinho where codigocolaborador = :codigocolaborador';
$stmt = $connect->prepare($qryCart); 
$stmt->bindValue(':codigocolaborador', $_SESSION['userId']);
$stmt->execute();
$result = $stmt->fetchAll();

foreach ($result as $value){
    $countCart = $value['countcart']; 
}
?>
<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="product.php">
        <div class="sidebar-brand-icon rotate-n-15">
          <img class="img-profile rounded-circle" src="img/minilogoo.png">  
        </div>
        <div class="sidebar-brand-text mx-3">Voloski Revendedora</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Nav Item - Tables -->
      <li class="nav-item">
        <a class="nav-link" href="order-report.php">
          <i class="fas fa-fw fa-table"></i>
          <span>Histórico</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <!-- Nav Item - Search Dropdown (Visible Only XS) -->
            <li class="nav-item dropdown no-arrow d-sm-none">
              <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
              </a>
              <!-- Dropdown - Messages -->
              <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                  <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                      <button class="btn btn-primary" type="button">
                        <i class="fas fa-search fa-sm"></i>
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </li>

            <!-- Nav Item - Alerts -->
            <li class="nav-item dropdown no-arrow mx-1">
            <div class="nav-link dropdown-toggle">
                  <a class="fa fa-shopping-cart text-gray-600" href="cart.php"></a>
                  <span class="badge badge-danger badge-counter"><?php echo $countCart ?></span>
                </div>
              </a> <!-- Dropdown - Alerts -->
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $_SESSION['username']?> </span>
                <img class="img-profile rounded-circle" src="img/img1.png">
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Sair
                </a>
              </div>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">
      </div>
      <!-- End of Main Content -->
         <!-- Begin Page Content -->
         <div class="container-fluid">
<!-- Page Heading -->
<?php
$qryCountOrder = 'select count(*) counter from pedidos where codigocolaborador = :codigocolaborador';
$stmt = $connect->prepare($qryCountOrder); 
$stmt->bindValue(':codigocolaborador', $_SESSION['userId']);
$stmt->execute();
$result = $stmt->fetchAll();

foreach ($result as $value){
  $countOrder = $value['counter'];
}
?>
<?php
if ($countOrder > 0){ ?>
<h1 class="h3 mb-2 text-gray-800">Histórico de Pedidos</h1>
<br/>
<form action='order-report.php' class='form-inline' method='POST'>
<select  class="form-control" name="status" style="margin-left: 10px; margin-top: 12px; width:180px; height:28px; font-size: 11px;">
<option value="" disabled selected>Status</option>
<option value="Faturado">Faturado</option>
<option value="Não Faturado">Não Faturado</option>
<option value="Cancelado">Cancelado</option>
</select>
<button type="submit" class="btn btn-primary" style="margin-left: 10px; margin-top: 16px; width:100px; height:28px; font-size: 11px; margin-top: 11px;"> Buscar</button>
</form>
<br/>
<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>Documento</th>
            <th>Tipo Operação</th>
            <th>Status</th>
            <th>Data</th>
            <th>Valor Total</th>
            <th>Detalhes</th>
          </tr>
        </thead>
        <tbody>
<?php 
if ((isset($_POST['status']) != "")){
  $qryOrder = 'select * from pedidos where codigocolaborador = :codigocolaborador and status = :status';
  $stmt = $connect->prepare($qryOrder); 
  $stmt->bindValue(':codigocolaborador', $_SESSION['userId']);
  $stmt->bindValue(':status', $_POST['status']);
  $stmt->execute();
} else {
  $qryOrder = 'select * from pedidos where codigocolaborador = :codigocolaborador';
  $stmt = $connect->prepare($qryOrder); 
  $stmt->bindValue(':codigocolaborador', $_SESSION['userId']);
  $stmt->execute();
}
$result = $stmt->fetchAll();

foreach ($result as $value){
  $document = $value['documento'];
  $status = $value['status'];
  $totalValue = $value['valortotal'];
  $date = $value['datacadastro'];
  $operation = $value['operacao'];
  $code = $value['codigo'];
?>
          <tr>
            <td><?php echo $document; ?></td>
            <td><?php echo $operation; ?></td>
            <td><?php echo $status; ?></td>
            <td><?php echo $date; ?></td>
            <td><?php echo "R$ ".number_format($totalValue, 2);?></td>
            <td><a href="#" class="btn btn-primary"  data-toggle="modal" data-target="#myModal<?php echo $code;?>"><center><h6 style="font-size: 11px; margin-top: 5px;">Detalhes</h6></center></a></td>
          </tr>
<?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php 
if ((isset($_POST['status']) != "")){
  $qryOrder = 'select * from pedidos where codigocolaborador = :codigocolaborador and status = :status';
  $stmt = $connect->prepare($qryOrder); 
  $stmt->bindValue(':codigocolaborador', $_SESSION['userId']);
  $stmt->bindValue(':status', $_POST['status']);
  $stmt->execute();
} else {
  $qryOrder = 'select * from pedidos where codigocolaborador = :codigocolaborador';
  $stmt = $connect->prepare($qryOrder); 
  $stmt->bindValue(':codigocolaborador', $_SESSION['userId']);
  $stmt->execute();
}

$result = $stmt->fetchAll();

foreach ($result as $value){
  $code = $value['codigo']; 
?>
  <div class="modal fade" id="myModal<?php echo $code;?>" role="dialog">
    <div class="modal-dialog modal-lg">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <p class="modal-title">Itens do Pedido:</p>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
<?php 
  $orderQuantity = 0;
  $totalOrderItem = 0;
  $qryItems = 'select p.*, ip.quantidade 
                 from itenspedido ip inner join produto p on ip.codigoproduto = p.codigo
                where ip.atendimento = :atendimento'; 
  $stmtPlus = $connect->prepare($qryItems); 
  $stmtPlus->bindValue(':atendimento', $code);
  $stmtPlus->execute();

  $resultPlus = $stmtPlus->fetchAll();

foreach ($resultPlus as $valuePlus){
  $image = $valuePlus['img']; 
  $description = $valuePlus['descricao']; 
  $orderQuantity = $valuePlus['quantidade']; 
  $money = $valuePlus[$_SESSION['practiced']];

  $totalOrderItem = $money * $orderQuantity;
?>
<div class="card shadow mb-4">
  <div class="card-header py-3">
 <h6 class="m-0 font-weight-bold text-primary" style="float: left;"><?php echo $description;?></h6></a>
  </div>
  <div class="card-body">
  <div style="float: right;">
</div>
  <div style="float: left;">
  <img class="img-profile rounded-circle" height="100px" src="<?php echo $image;?>">
</div>
<h6 style="font-size: 16px; float: left; margin-top: 10px;"><?php echo "Valor unitário: R$ ".number_format($money, 2);?></h6>
<br/>
<br/>
<h6 style="font-size: 16px; margin-left: 30px"> <?php echo "Quantiadade: ".number_format($orderQuantity, 0)." unidades";?></h6> 
<br/>
<h6 style="font-size: 16px; color: black; float: right; margin-top: 10px;"><?php echo "Valor total: R$ ".number_format($totalOrderItem, 2);?></h6>
<br/>
</div>
</div>
<?php } ?>
        <div class="modal-footer">
          <button type="submit" class="btn btn-default" data-dismiss="modal">Sair</button>
        </div>
      </div>
    </div>
  </div>
  <?php }?>
</div> 
<?php } else { ?>
<!-- /.container-fluid -->
<center><h1> Não há histórico de pedidos! </h1> </center>
</div>
<?php } ?>


      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; Voloski & Fracaro 2020</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tem certeza que deseja sair?</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">Selecione "Sair" abaixo se você deseja terminar sua sessão atual.</div>
      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Voltar</button>
        <a class="btn btn-primary" href="index.php">Sair</a>
      </div>
    </div>
  </div>
</div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="vendor/chart.js/Chart.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="js/demo/chart-area-demo.js"></script>
  <script src="js/demo/chart-pie-demo.js"></script>

</body>

</html>
