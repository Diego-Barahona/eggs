<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="hidratec-admin">
    <meta name="author" content="Sistema Hidratec ">

    <title>Administración Sistema Comercial Ceballos</title>

    <!-- Custom fonts for this template-->
    <link href="<?php echo base_url(); ?>assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?php echo base_url(); ?>assets/css_admin/sb-admin-2.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/vendor/DataTables/datatables.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/vendor/DataTables/fixedHeader.dataTables.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/vendor/jquery-ui-1.12.1.custom/jquery-ui.css" type="text/css" rel="stylesheet"/>
    <script>
    const host_url = "<?php echo base_url(); ?>";
  </script>
<script src="https://www.gstatic.com/charts/loader.js"></script>
  <style type="text/css">
    .chargePage {
      display: none;
      position: fixed;
      z-index: 10000;
      top: 0;
      left: 0;
      height: 100%;
      width: 100%;
      background: rgba(255, 255, 255, .8) url('<?php echo base_url(); ?>assets/img/loading.svg') 50% 50% no-repeat
    }

    body.loading .chargePage {
      overflow: hidden;
      display: block
    }

    .box {
      margin-top: 50px;
      padding: 15px
    }
  </style>
</head>

<body id="page-top">
<div class="chargePage"></div>
    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center pb-4" href="<?php echo base_url(); ?>adminCards">

            <img src="<?php echo base_url(); ?>assets/img/logos/side2.png" style="height:100px ;width:150px" >

            </a>
           

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url(); ?>adminCards">
                    <i class="fas fa-home"></i>
                    <span>Inicio</span></a>
                    <hr class="sidebar-divider">
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url(); ?>adminUser">
                    <i class="fas fa-user"></i>
                    <span>Usuarios</span>
                </a>
            </li>
            <hr class="sidebar-divider">

            <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url(); ?>cliente">
                    <i class="fas fa-users"></i>
                    <span>Clientes</span>
                </a>
                <hr class="sidebar-divider">

<!-- Nav Item - Utilities Collapse Menu -->
<li class="nav-item">
   <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseProveedor"
       aria-expanded="true" aria-controls="collapseUtilities">
       <i class="fas fa-shopping-cart"></i>
       <span>Proveedores</span>
   </a>
   <div id="collapseProveedor" class="collapse" aria-labelledby="headingUtilities"
       data-parent="#accordionSidebar">
       <div class="bg-white py-2 collapse-inner rounded">
           <h6 class="collapse-header">Gestión Proveedores</h6>
           <a class="collapse-item" href="<?php echo base_url(); ?>adminProveedor"><i class="fas fa-user fa-fw"></i> Lista de Proveedores</a>
           <a class="collapse-item" href="<?php echo base_url(); ?>adminProveedorHuevo"><i class="fas fa-egg fa-fw"></i> Proveedores-Huevos</a>  
           <a class="collapse-item" href="<?php echo base_url(); ?>adminProveedorCigarro"><i class="fas fa-smoking fa-fw"></i> Proveedores-Cigarros</a>
       </div>
   </div>
   <!-- <hr class="sidebar-divider"> -->
</li>

            <!-- Divider -->
            <hr class="sidebar-divider">

             <!-- Nav Item - Utilities Collapse Menu -->
             <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseProducts"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-store"></i>
                    <span>Productos</span>
                </a>
                <div id="collapseProducts" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Gestión Productos</h6>

                        <a class="collapse-item" href="<?php echo base_url(); ?>adminEggs"><i class="fas fa-egg fa-fw"></i> Huevos</a>
                        <a class="collapse-item" href="<?php echo base_url(); ?>adminCigar"><i class="fas fa-smoking fa-fw"></i> Cigarrillos</a>  

                    </div>
                </div>
                <hr class="sidebar-divider">
            </li>


            <!-- Nav Item - Box -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBox"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-cash-register"></i>
                    <span>Caja</span>
                </a>
                <div id="collapseBox" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Gestión Caja</h6>

                        <a class="collapse-item" href="<?php echo base_url(); ?>gastosGenerales"><i class="fas fa-comments-dollar fa-fw"></i> Gastos</a>
                        <a class="collapse-item" href="<?php echo base_url(); ?>adminCost"><i class="fas fa-comments-dollar fa-fw"></i> Costos</a>
                        <a class="collapse-item" href=""><i class="fas fa-clipboard-check fa-fw"></i> Ventas</a>  
                        <a class="collapse-item" href=""><i class="fas fa-coins fa-fw"></i> Utilidades</a>  
                    </div>
                </div>
                <hr class="sidebar-divider">
            </li>

        
            <!-- Nav Item - Routes-->
           <!--  <li class="nav-item">
                <a class="nav-link collapsed" href="<?//php echo base_url(); ?>adminRoutes">
                <i class="fas fa-map-signs"></i>
                    <span>Rutas</span>
                </a>
            </li> -->



            <!-- Nav Item - Box -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#Routes"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-map-signs"></i>
                    <span>Rutas</span>
                </a>
                <div id="Routes" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Gestión Ruta</h6>
                        <a class="collapse-item" href="<?php echo base_url(); ?>adminRoutes">Planificación</a>
                        <a class="collapse-item" href="<?php echo base_url(); ?>adminRoutes">Llenado</a>
                    </div>
                </div>
                <hr class="sidebar-divider">
            </li>











            <!-- Nav Item - Charts -->
            <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url(); ?>adminCharts">
                    <i class="fas fa-chart-bar"></i>
                    <span>Gráficos</span></a>
                    <hr class="sidebar-divider">
            </li>
            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->
<!------------------------------------------------------      content                                        ------------------------------------------------------------->
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-gradient-secondary topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">



                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-white small"><?php echo $_SESSION['full_name'];?></span>
                                <i class="fas fa-power-off" style="color:white; font-size:20px"></i>
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Perfil del usuario 
                                </a>
                            
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal"  data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Cerrar sesión
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->


<!-- Logout Modal Close sesion -->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">¿Seguro quieres salir del sistema?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Selecciona "Salir" si deseas cerrar la sesión.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button"  data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" id="logout" >Salir</a>
                </div>
            </div>
        </div>
    </div>

    <script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
   

    <!-- Core plugin JavaScript-->
    <script src="<?php echo base_url(); ?>assets/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/vendor/DataTables/datatables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/vendor/DataTables/dataTables.fixedHeader.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="<?php echo base_url(); ?>assets/js_admin/sb-admin-2.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js_admin/menu.js"></script>

    <script src="<?php echo base_url(); ?>assets/vendor/jquery-ui-1.12.1.custom/jquery-ui.js"></script>
    <script src="<?php echo base_url(); ?>assets/vendor/lodash/lodash.js"></script>
    <script src="https://markcell.github.io/jquery-tabledit/assets/js/tabledit.min.js"></script>
    <script src="  https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.21/lodash.min.js"></script>
    

   
  
    

