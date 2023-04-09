
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

<body id="page-top">
<?php include 'session.php'; 
$total = 0;
$conn = getConnection();

$qryCart = 'select count(*) countcart from carrinho where codigocolaborador = :codigocolaborador';
$stmt = $connect->prepare($qryCart); 
$stmt->bindValue(':codigocolaborador', $_SESSION['userId']);
$stmt->execute();
$result = $stmt->fetchAll();

foreach ($result as $value){
    $countCart = $value['countcart']; 
}
?>
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
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $_SESSION['username']?></span>
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
        <div class="container-fluid">
<?php if ($countCart > 0) { ?> 
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">CARRINHO</h1>
   </div>
<?php
$total = 0; 
$practiced = $_SESSION['practiced'];
$qrySumMoney = "select sum(p.".$practiced." * c.quantidade) as total
                  from produto p inner join carrinho c on c.codigoproduto = p.codigo 
                 where c.codigocolaborador = :codigocolaborador";
$stmt = $conn->prepare($qrySumMoney); 
$stmt->bindValue(':codigocolaborador', $_SESSION['userId']);
$stmt->execute();
$result = $stmt->fetchAll();

foreach ($result as $value) {
  $total =  $value['total'];
} 
?>
   <div class="row">
   <div class="card-body"> 
   <form action="insert-order.php" method="POST">
   <a href="product.php"><button type="button" class="btn btn-primary" style="margin-right: 10px; margin-top: 10px;"><center><h6 style="font-size: 11px; margin-top: 5px;">Continuar Comprando</h6></center></button></a> 
    <button type="submit" class="btn btn-primary" style="margin-top: 10px; margin-right: 65px;" ><center><h6 style="font-size: 11px; margin-top: 5px;">Finalizar Compra</h6></center></button>
    <h6 style="font-size: 18px; color: black; float: right; margin-top: 12px; margin-left: 520px;" class="col-xs-6 .col-sm-3"> <?php echo "Valor total: R$ ".number_format($total, 2); ?> </h6>
    <input type="hidden" name="total" value="<?php echo $total;?>">
    </form>
    </div>
    </div>
    <br/>
<?php 
$qrySelectCart = "select p.*, c.quantidade, c.codigoproduto, c.codigo 
                    from produto p inner join carrinho c on c.codigoproduto = p.codigo 
                   where c.codigocolaborador = :codigocolaborador";
$stmt = $conn->prepare($qrySelectCart); 
$stmt->bindValue(':codigocolaborador', $_SESSION['userId']);
$stmt->execute();
$result = $stmt->fetchAll();

foreach ($result as $value) {
  $codeCart = $value['codigo'];  
  $codeProd = $value['codigoproduto']; 
  $description = $value['descricao']; 
  $quantity = $value['quantidade']; 
  $money = $value[$_SESSION['practiced']];
  $img = $value['img']; 
?>
 <div class="card shadow mb-4">
  <div class="card-header py-3">
  <h6 class="m-0 font-weight-bold text-primary" style="float: left;"><?php echo $description; ?></h6></a>
  </div>
  <div class="card-body">
  <div style="float: right;">
  <a href="#" class="btn btn-warning btn-circle" style="margin-left: 130px; margin-top: 15px;" data-toggle="modal" data-target="#myModal<?php echo $codeCart;?>">
  <i class="fa fa-list"></i></a>
  <br/>
  <a href="delete-cart.php?code=<?php echo $codeCart;?>" class="btn btn-danger btn-circle" style="margin-left: 130px; margin-top: 15px;">
  <i class="fas fa-trash"></i></a>
</div>
  <div style="float: left;">
  <img class="img-profile rounded-circle" height="100px" src="<?php echo $img; ?>">
</div>
<h6 style="font-size: 18px; color: black; float: left; margin-top: 10px;"> <?php echo "R$ ".number_format($money, 2); ?> </h6>
<br/><br/>
<h6 style="font-size: 14px; color: black;"> <?php echo "Quantidade solicitada: ".number_format($quantity, 0)." unidades";?> </h6> 
  </div>
  </div>
<?php }?> 

  <!-- Modal -->
  <?php 
$qrySelectCart = "select p.*, c.quantidade, c.codigoproduto, c.codigo 
                    from produto p inner join carrinho c on c.codigoproduto = p.codigo 
                   where c.codigocolaborador = :codigocolaborador";
$stmt = $conn->prepare($qrySelectCart); 
$stmt->bindValue(':codigocolaborador', $_SESSION['userId']);
$stmt->execute();
$result = $stmt->fetchAll();

foreach ($result as $value) {
  $codeCart = $value['codigo'];  
  $codeProd = $value['codigoproduto']; 
  $description = $value['descricao']; 
  $quantity = $value['quantidade']; 
  $money = $value[$_SESSION['practiced']];
  $img = $value['img']; 
?>
  <form action="update-cart.php" method="POST">
  <div class="modal fade" id="myModal<?php echo $codeCart;?>" role="dialog">
    <div class="modal-dialog modal-sm">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <p class="modal-title">Nova quantidade:</p>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <input type="number" name="qtd" class="form-control" min="1">
          <input type="hidden" name="code" value="<?php echo $codeCart;?>">
          <input type="hidden" name="codeprod" value="<?php echo $codeProd;?>">
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
          <button type="submit" value="submit" class="btn btn-default">Concluir</button>
        </div>
      </div>
    </div>
  </div>
  </form>
  <?php }?>
<?php } else { ?>
<center><h1> Não há itens no carrinho!</h1></center>
<?php } ?>
<!-- Error -->
<?php if(isset($_GET["erro"])) { echo "<script> alert('Não foi possivel deletar este item!'); </script>"; } ?>
<?php if(isset($_GET["erroed"])) { echo "<script> alert('Não foi possivel editar este item!'); </script>"; } ?>
<?php if(isset($_GET["qtd"])) { echo "<script> alert('Digite uma quantidade!'); </script>"; } ?>
<?php if(isset($_GET["qtdr"])) { echo "<script> alert('Quantidade solicitada não está disponivel!'); </script>"; } ?>
<?php if(isset($_GET["ped"])) { echo "<script> alert('Erro ao inserir o pedido!'); </script>"; } ?>
<?php if(isset($_GET["iped"])) { echo "<script> alert('Erro ao inserir os itens do pedido!'); </script>"; } ?>
<?php if(isset($_GET["ucode"])) { echo "<script> alert('Erro ao inserir ultimos codigos!'); </script>"; } ?>
<div class="row">
</div>
        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
          </div>

          <!-- Content Row -->
          <div class="row">

      </div>
      <!-- End of Main Content -->

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


