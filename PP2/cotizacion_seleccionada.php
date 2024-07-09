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

require_once 'funciones/buscarCotizacionPorId.php';

require_once 'funciones/select_cotizaciones.php';
$ListadoCotizaciones = Listar_Cotizaciones($MiConexion);
$CantidadCotizaciones = count($ListadoCotizaciones);


if (isset($_GET['id'])) {
    // Obtener el ID de la cotizacion seleccionado desde la URL
    $idCotizacionDetalle = $_GET['id'];

    // Verificar que el ID de la cotizacion no esté vacío o sea un valor no válido
    if (empty($idCotizacionDetalle) || !is_numeric($idCotizacionDetalle)) {
        // Si el ID es inválido, redirigir a la página principal o mostrar un mensaje de error
        header('Location: consulta_cotizaciones.php');
        exit;
    }

// Cargar los datos de la cotizacion seleccionada desde la base de datos
$cotizacionDetalle = ObtenerCotizacionPorId($MiConexion, $idCotizacionDetalle);

if (empty($cotizacionDetalle)) {
    // Si no se encontró la cotizacion para modificar, redirigir al listado de cotizaciones
    header('Location: consulta_cotizaciones.php');
    exit;
}

} else {
    // Si no se recibió el parámetro 'id' en la URL, redirigir a la página principal o mostrar un mensaje de error
    header('Location: index.php');
    exit;
}

$imagen = $cotizacionDetalle['COTIZACIONIMAGEN'];

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
	                            <h5 class="m-b-10">Administración de Proveedores</h5>
	                        </div>
	                        <ul class="breadcrumb">
	                            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
	                            <li class="breadcrumb-item"><a href="#!">Proveedores</a></li>
	                            <li class="breadcrumb-item">Detalle de la cotización</li>
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
                        <h5>Cotización</h5>
                        <hr>
                        <?php require_once 'alertas.inc.php'; ?>


            <form role="form" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6">

                        <div class="mb-3">
						    <label for="detalleCotizacion" class="form-label">Detalle cotización</label>
						    <textarea class="form-control" id="detalleCotizacion" name="detalleCotizacion" rows="4"><?php echo $cotizacionDetalle['DETALLECOTIZACION']; ?></textarea>
						</div>

						<div class="mb-3">
						    <label for="cotizacionTexto" class="form-label">Cotización (texto)</label>
						    <textarea class="form-control" id="cotizacionTexto" name="cotizacionTexto" rows="4"><?php echo $cotizacionDetalle['COTIZACIONTEXTO']; ?></textarea>
						</div>

                        <div class="mb-3">
                            <label class="form-label">Cotización (imágen)</label></br>
                            <?php
                            $imagenCodificada = $cotizacionDetalle['COTIZACIONIMAGEN'];
                            $imagenDecodificada = base64_decode($imagenCodificada);

                            // Verificar si la decodificación tuvo éxito y si es una imagen válida
                            if ($imagenDecodificada !== false) {
                                // Obtener información sobre el tipo MIME de la imagen para establecer el encabezado adecuado
                                $finfo = new finfo(FILEINFO_MIME_TYPE);
                                $tipoImagen = $finfo->buffer($imagenDecodificada);

                                // Mostrar la imagen si es válida
                                echo '<img src="data:' . $tipoImagen . ';base64,' . $imagenCodificada . '" class="img-fluid">';
                            } else {
                                echo 'Error al decodificar la imagen.';
                            }
                            ?>
                        </div>

                    </div>
                </div>
                <div class="col-md-12">
				    <a class="btn btn-secondary" href="consulta_cotizaciones.php" role="button">Volver al listado</a>
				    <?php require_once 'boton.imprimir.inc.php'; ?>
				</div>
            </form>
        </div>
    </div>
</section>

<?php require_once 'footer.inc.php'; ?>
<?php require_once 'funciones/script.imprimir.inc.php'; ?>
