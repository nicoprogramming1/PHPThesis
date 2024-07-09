<?php 
session_start();

if (empty($_SESSION['Usuario_Nombre'])) {
    header('Location: cerrarsesion.php');
    exit;
}

require_once 'funciones/conexion.php';
$MiConexion=ConexionBD(); 

require_once 'funciones/select_eventos.php';
$ListadoEventos = Listar_Eventos($MiConexion);
$CantidadEventos= count($ListadoEventos);


require_once 'funciones/validaciones.php';
$Mensaje='';
$Estilo='warning';
if (!empty($_POST['BotonModificar'])) {
    //estoy en condiciones de poder validar los datos
    $Mensaje=Validar_Seleccion_Modificar_Eventos();
    if (empty($Mensaje)) {
        // Obtener los IDs de los eventos seleccionados
        $eventosSeleccionados = $_POST['seleccionar'];

        // Redirigir a la página de modificación con los IDs seleccionados como parámetros
        header('Location: modificar_evento.php?id=' . implode(',', $eventosSeleccionados));
        exit;
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
                            <h5 class="m-b-10">Eventos</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item"><a href="#!">Listado de eventos</a></li>
                        </ul>


                    <div class="card-body table-border-style">
                    	<?php require_once 'alertas.inc.php'; ?>
                        	<form role="form" method="post">
	                        	<div class="row">
		                            <table class="table">
		                                <thead>
		                                    <tr>
		                                    	<?php require_once 'vercolumnas.eventos.inc.php'; ?>
		                                    </tr>
		                                </thead>
		                                <tbody>
		                                	    <?php require_once 'listado.eventos.inc.php'; ?>                                
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
