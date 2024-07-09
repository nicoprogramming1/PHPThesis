<?php
session_start();

if (empty($_SESSION['Usuario_Nombre'])) {
    header('Location: cerrarsesion.php');
    exit;
}

require_once 'funciones/conexion.php';
$MiConexion = ConexionBD();

require_once 'funciones/validaciones.php';

$Mensaje = '';
$Estilo = 'warning';

require_once 'funciones/buscarRecepcionPorId.php';

if (isset($_GET['id'])) {
    // Obtener el ID de la recepción seleccionado desde la URL
    $idRecepcionDetalle = $_GET['id'];

    
// Cargar los datos de la recepción seleccionada desde la base de datos
$recepcionDetalle = ObtenerRecepcionPorId($MiConexion, $idRecepcionDetalle);

if (empty($recepcionDetalle)) {
    // Si no se encontró la recepción para modificar, redirigir al listado de cotizaciones
    header('Location: consulta_recepciones.php');
    exit;
}

} else {
    // Si no se recibió el parámetro 'id' en la URL, redirigir a la página principal o mostrar un mensaje de error
    header('Location: index.php');
    exit;
}

$fechaRemito = date('d/m/y', strtotime($recepcionDetalle['FECHAREMITO']));
$remito = $recepcionDetalle['REMITO'];

require_once 'header.inc.php';
?>

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
		<a href="index.html" class="b-brand">
                    <!-- ========   change your logo hear   ============ -->
                    <span>ELITE APP</span>
                </a>
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
	                            <h5 class="m-b-10">Administración de Stock</h5>
	                        </div>
	                        <ul class="breadcrumb">
	                            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
	                            <li class="breadcrumb-item"><a href="#!">Stock</a></li>
	                            <li class="breadcrumb-item">Detalle de la recepción</li>
	                        </ul>
	                    </div>
	                </div>
	            </div>
	        </div>
	        <!-- [ breadcrumb ] end -->

<!-- [ Main Content ] start -->

<!-- [ Main Content ] start -->
        <div class="row">
            <!-- [ form-element ] start -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h5>Detalle de la recepción con ID = <?php echo $recepcionDetalle['IDRECEPCIONCOMPRA']; ?></h5>
            <hr>
                        <?php require_once 'alertas.inc.php'; ?>


            <form role="form" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6">

                        <div class="mb-3">
						    <label for="detalleRecepcion" class="form-label">Detalle recepción</label>
						    <textarea class="form-control" id="detalleRecepcion" name="detalleRecepcion" rows="4"><?php echo $recepcionDetalle['DETALLERECEPCION']; ?></textarea>
						</div>

						<div class="mb-3">
						    <label for="nroRemito" class="form-label">Nro Remito</label>
						    <textarea class="form-control" id="nroRemito" name="nroRemito" rows="4"><?php echo $recepcionDetalle['NROREMITO']; ?></textarea>
						</div>

						<div class="mb-3">
                            <label for="fechaRemito" class="form-label">Fecha de remito</label>
                            <input type="text" class="form-control" id="fechaRemito" name="fechaRemito" placeholder="Selecciona la fecha que figura en el remito" value="<?php echo $fechaRemito; ?>">
                        </div>

						<div class="mb-3">
						    <label for="detalleRemito" class="form-label">Detalle remito</label>
						    <textarea class="form-control" id="detalleRemito" name="detalleRemito" rows="4"><?php echo $recepcionDetalle['DETALLEREMITO']; ?></textarea>
						</div>

						<div class="mb-3">
						    <label for="detalleMercaderia" class="form-label">Detalle de la mercadería ingresada</label>
						    <textarea class="form-control" id="detalleMercaderia" name="detalleMercaderia" rows="4"><?php echo $recepcionDetalle['DETALLEMERCADERIA']; ?></textarea>
						</div>

                        <div class="mb-3">
							    <label for="remito" class="form-label">Remito</label>
							    <img src="data:image/jpeg;base64,<?php echo base64_encode($remito); ?>" class="img-fluid" alt="Remito">
							</div>
                        <script>
                            $('#fechaRemito').datetimepicker({
                                format: 'DD/MM/YY', // Formato latino "dd/mm/yy"
                                icons: {
                                    time: "far fa-clock",
                                    date: "far fa-calendar",
                                    up: "fas fa-chevron-up",
                                    down: "fas fa-chevron-down",
                                    previous: "fas fa-chevron-left",
                                    next: "fas fa-chevron-right",
                                    today: "far fa-calendar-check",
                                    clear: "far fa-trash-alt",
                                    close: "far fa-times-circle"
                                }
                            });
                        </script>
                    </div>
                </div>
                <div class="col-md-12">
				    <a class="btn btn-secondary" href="consulta_recepciones.php" role="button">Volver al listado</a>
				    <?php require_once 'boton.imprimir.inc.php'; ?>
				</div>
            </form>
        </div>
    </div>
</section>

<?php require_once 'footer.inc.php'; ?>
<?php require_once 'funciones/script.imprimir.inc.php'; ?>
