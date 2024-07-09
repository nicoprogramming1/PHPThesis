<?php 
session_start();

if (empty($_SESSION['Usuario_Nombre'])) {
    header('Location: cerrarsesion.php');
    exit;
}

require_once 'funciones/conexion.php';
$MiConexion=ConexionBD(); 

require_once 'funciones/select_tipoTickets.php';
$ListadoTipoTickets = Listar_tipoTickets($MiConexion);
$CantidadTipoTickets= count($ListadoTipoTickets);

require_once 'funciones/insertar_tipoTicket.php';


require_once 'funciones/validaciones.php';
$Mensaje='';
$Estilo='warning';
if (!empty($_POST['BotonModificar'])) {
    //estoy en condiciones de poder validar los datos
    $Mensaje=Validar_Seleccion_Modificar_TipoTickets();
    if (empty($Mensaje)) {
        // Obtener el id del tipoTicket seleccionado
        $tipoTicketSeleccionado = $_POST['seleccionar'];

        // Redirigir a la página de modificación con el id seleccionado como parámetro
        header('Location: modificar_tipoTicket.php?id=' . implode(',', $tipoTicketSeleccionado));
        exit;
    }
    else {
		$Estilo='danger';
    }
}


require_once 'header.inc.php'; ?>


</head>
<body class="">
	<!-- [ Pre-loader ] start -->
	<div class="loader-bg">
		<div class="loader-track">
			<div class="loader-fill"></div>
		</div>
	</div>
	<!-- [ Pre-loader ] End -->
	<!-- [ Mobile header ] start -->
	<div class="pc-mob-header pc-header">
		<div class="pcm-logo">
			<img src="assets/images/logo.svg" alt="" class="logo logo-lg">
		</div>
		<div class="pcm-toolbar">
			<a href="#!" class="pc-head-link" id="mobile-collapse">
				<div class="hamburger hamburger--arrowturn">
					<div class="hamburger-box">
						<div class="hamburger-inner"></div>
					</div>
				</div>
				<!-- <i data-feather="menu"></i> -->
			</a>

			<a href="#!" class="pc-head-link" id="header-collapse">
				<i data-feather="more-vertical"></i>
			</a>
		</div>
	</div>
	<!-- [ Mobile header ] End -->

	<!-- [ navigation menu ] start -->
	<nav class="pc-sidebar ">
		<div class="navbar-wrapper">
			<div class="m-header">
				<a href="index.html" class="b-brand">
                    <!-- ========   change your logo hear   ============ -->
                    <span>ELITE APP</span>
                </a>
			</div>
			<div class="navbar-content">
				<?php require_once 'menu.inc.php'; ?>
                 <!-- menu-nav -->
			</div>
		</div>
	</nav>
	<!-- [ navigation menu ] end -->
	<!-- [ Header ] start -->
	<header class="pc-header ">
		<div class="header-wrapper">
			
			<div class="ml-auto">
				<?php require_once 'user.search.inc.php'; ?>
                <!-- search-and-user-nav -->
			</div>

		</div>
	</header>

	<!-- [ Header ] end -->

<!-- [ Main Content ] start -->
<section class="pc-container">
    <div class="pcoded-content">
        <!-- [ breadcrumb ] start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Administración de Ventas</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item"><a href="#!">Listado de tipos de ticket de venta</a></li>
                        </ul>


                    <div class="card-body table-border-style">
                    	<?php require_once 'alertas.inc.php'; ?>
                        	<form role="form" method="post">
	                        	<div class="row">
		                            <table class="table">
		                                <thead>
		                                    <tr>
		                                    	<?php require_once 'vercolumnas.tiposTicket.inc.php'; ?>
		                                    </tr>
		                                </thead>
		                                <tbody>
		                                	    <?php require_once 'listado.tipoTickets.inc.php'; ?>                                
		                                </tbody>
		                            </table>
		                            <div class="col-md-12">
                                    <button class="btn  btn-primary" type="submit" value="Modificar" name="BotonModificar">Modificar
                                    </button>
                                    <a class="btn btn-light" href="index.php" role="button">Volver a Home</a>
                            </div>
		                        </div>
	                        </form>
                        </div>
                </div>
        </div>

                </div>


       

</section>
<?php require_once 'footer.inc.php'; ?>
