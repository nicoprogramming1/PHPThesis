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
require_once 'funciones/actualizarCotizacion.php';
require_once 'funciones/eliminarCotizacion.php';

require_once 'funciones/select_cotizaciones.php';
$ListadoCotizaciones = Listar_Cotizaciones($MiConexion);
$CantidadCotizaciones = count($ListadoCotizaciones);

require_once 'funciones/select_proveedoresList.php';
$ListadoProveedores = ObtenerListaProveedores($MiConexion);


if (isset($_GET['id'])) {
    // Obtener el ID de la cotización seleccionada desde la URL
    $idCotizacionModificar = $_GET['id'];

    // Verificar que el ID de la cotización no esté vacío o sea un valor no válido
    if (empty($idCotizacionModificar) || !is_numeric($idCotizacionModificar)) {
        // Si el ID es inválido, redirigir a la página principal o mostrar un mensaje de error
        header('Location: listado_cotizaciones.php');
        exit;
    }

// Cargar los datos de la cotizacion seleccionada desde la base de datos
$cotizacionAModificar = ObtenerCotizacionPorId($MiConexion, $idCotizacionModificar);

if (empty($cotizacionAModificar)) {
    // Si no se encontró la cotizacion para modificar, redirigir al listado de cotizaciones
    header('Location: listado_cotizaciones.php');
    exit;
}

$detalleCotizacion = $cotizacionAModificar['DETALLECOTIZACION'];
$fechaCotizacion = date('d/m/y', strtotime($cotizacionAModificar['FECHACOTIZACION']));
$cotizacionTexto = $cotizacionAModificar['COTIZACIONTEXTO'];
$cotizacionImagen = $cotizacionAModificar['COTIZACIONIMAGEN'];
$idProveedor = $cotizacionAModificar['IDPROVEEDOR'];

} else {
    // Si no se recibió el parámetro 'id' en la URL, redirigir a la página principal o mostrar un mensaje de error
    header('Location: index.php');
    exit;
}

// Procesar el formulario de modificación
if (!empty($_POST['BotonGuardar'])) {
    // Estoy en condiciones de poder validar los datos
    $Mensaje = Validar_Datos_Modificar_Cotizacion();
    if (empty($Mensaje)) {
        // Obtener los nuevos valores del formulario
        $detalleCotizacion = $_POST['detalleCotizacion'];
        $fechaCotizacion = $_POST['fechaCotizacion'];
        $cotizacionTexto = $_POST['cotizacionTexto'];
        $idProveedorSeleccionado = $_POST['nombreProveedor'];

        // Manejar la actualización de la imagen de la cotizacion si es necesario
        if (!empty($_FILES['cotizacionImagen']['tmp_name'])) {
            $imagenNueva = file_get_contents($_FILES['cotizacionImagen']['tmp_name']);
        } else {
            $imagenNueva = ''; // Mantener la imagen existente
        }

        // Actualizar la cotizacion en la base de datos
        if (actualizarCotizacion($MiConexion, $idCotizacionModificar, $fechaCotizacion, $cotizacionTexto, $imagenNueva, $detalleCotizacion, $idProveedorSeleccionado)) {
            $Mensaje = 'Cotización actualizada exitosamente.';
            $Estilo = 'success';
        } else {
            $Mensaje = 'Error al actualizar la cotización.';
            $Estilo = 'danger';
        }
    }
}

if (isset($_POST['BotonCancelar'])) {

    if (eliminarCotizacion($MiConexion, $idCotizacionModificar)) {
        $Mensaje = 'Se ha eliminado la cotización.';
        $Estilo = 'success';
        // Redirigir a la lista cotizaciones después de la cancelacion exitosa
        header('Location: listado_cotizaciones.php');
        exit;
    } else {
        $Mensaje = 'Error al el eliminar la cotización.';
        $Estilo = 'danger';
    }
}

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
	                            <li class="breadcrumb-item">Modificar cotización</li>
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
                        <h5>Modificar cotización</h5>
                        <hr>
                        <?php require_once 'alertas.inc.php'; ?>

                        <div class="alert alert-info" role="alert">
                        <i data-feather="info"></i> 
							Los campos con * son obligatorios. 
						</div>

            <form role="form" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6">

                        <div class="mb-3">
						    <label for="detalleCotizacion" class="form-label">Detalle cotización</label>
						    <textarea class="form-control" id="detalleCotizacion" name="detalleCotizacion" rows="4"><?php echo $detalleCotizacion; ?></textarea>
						</div>

						<div class="mb-3">
						    <label for="cotizacionTexto" class="form-label">Cotización (texto)</label>
						    <textarea class="form-control" id="cotizacionTexto" name="cotizacionTexto" rows="4"><?php echo $cotizacionTexto; ?></textarea>
						</div>

                        <div class="mb-3">
                            <label for="cotizacionImagen" class="form-label">Subir y reemplazar cotizacion cargada</label>
                            <input type="file" class="form-control" id="cotizacionImagen" name="cotizacionImagen">
                        </div>

                        <div class="mb-3">
						    <label for="cotizacionImagen" class="form-label">Cotización</label>
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

						<div class="mb-3">
						    <label for="fechaCotizacion" class="form-label">Fecha de la cotización (*)</label>
						    <input type="text" class="form-control" id="fechaCotizacion" name="fechaCotizacion" placeholder="Selecciona la fecha de la cotización" value="<?php echo $fechaCotizacion; ?>">
						</div>

						<div class="form-group">
						    <label for="nombreProveedor" class="form-label">Proveedor (*)</label>
						    <select class="form-control" name="nombreProveedor" id="nombreProveedor">
						        <?php
						        foreach ($ListadoProveedores as $proveedor) {
						            $selected = ($proveedor['idProveedor'] == $idProveedor) ? 'selected' : '';
						            echo '<option value="' . $proveedor['idProveedor'] . '" ' . $selected . '>' . $proveedor['nombreProveedor'] . ' (ID: ' . $proveedor['idProveedor'] . ')</option>';
						        }
						        ?>
						    </select>
						</div>

                    </div>
                </div>
                <div class="col-md-12">
					<button class="btn btn-primary" type="submit" value="Guardar" name="BotonGuardar">Guardar Cambios</button>
					<button type="submit" class="btn btn-danger" name="BotonCancelar" onclick="return confirm('¿Estás seguro de que deseas eliminar esta cotizacion?')">Eliminar cotización</button>
				    <a class="btn btn-secondary" href="listado_cotizaciones.php" role="button">Volver al listado</a>
				</div>
            </form>
        </div>
    </div>
</section>
<script>
	$('#fechaCotizacion').datetimepicker({
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
<?php require_once 'footer.inc.php'; ?>