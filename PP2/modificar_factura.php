<?php
session_start();

if (empty($_SESSION['Usuario_Nombre'])) {
    header('Location: cerrarsesion.php');
    exit;
}

require_once 'funciones/conexion.php';
$MiConexion = ConexionBD();

require_once 'funciones/select_facturas.php';
require_once 'funciones/validaciones.php';

$Mensaje = '';
$Estilo = 'warning';

require_once 'funciones/buscarFacturaPorId.php';
require_once 'funciones/actualizarFactura.php';

require_once 'funciones/select_proveedoresList.php';
$ListadoProveedores = ObtenerListaProveedores($MiConexion);

require_once 'funciones/select_estadosFacturaList.php';
$ListadoEstadosFactura = ObtenerListaEstadosFactura($MiConexion);

if (isset($_GET['id'])) {
    // Obtener el ID de la factura seleccionado desde la URL
    $idFacturaModificar = $_GET['id'];

    // Verificar que el ID de la factura no esté vacío o sea un valor no válido
    if (empty($idFacturaModificar) || !is_numeric($idFacturaModificar)) {
        // Si el ID es inválido, redirigir a la página principal o mostrar un mensaje de error
        header('Location: listado_facturas.php');
        exit;
    }

// Cargar los datos de la factura seleccionada desde la base de datos
$facturaAModificar = ObtenerFacturaPorId($MiConexion, $idFacturaModificar);

if (empty($facturaAModificar)) {
    // Si no se encontró la factura para modificar, redirigir al listado de facturas
    header('Location: listado_facturas.php');
    exit;
}

$nroFactura = $facturaAModificar['nroFactura'];
$importeFactura = $facturaAModificar['importe'];
$fechaFactura = date('d/m/y', strtotime($facturaAModificar['fechaFactura']));
$detalleFactura = $facturaAModificar['detalleFactura'];
$nombreProveedor = $facturaAModificar['nombreProveedor'];
$factura = $facturaAModificar['factura'];
$estadoFactura = $facturaAModificar['idEstadoFactura'];

} else {
    // Si no se recibió el parámetro 'id' en la URL, redirigir a la página principal o mostrar un mensaje de error
    header('Location: index.php');
    exit;
}

// Procesar el formulario de modificación
if (!empty($_POST['BotonGuardar'])) {
    // Estoy en condiciones de poder validar los datos
    $Mensaje = Validar_Datos_Modificar_Factura();
    if (empty($Mensaje)) {
        // Obtener los nuevos valores del formulario
        $nroFactura = $_POST['nroFactura'];
        $importeFactura = $_POST['importeFactura'];
        $nuevaFecha = date('y/m/d', strtotime($_POST['fechaFactura']));
        $nuevoDetalle = $_POST['detalleFactura'];
        $idProveedor = $_POST['proveedor'];
        $nuevoEstado = $_POST['estadoFactura'];

        // Manejar la actualización de la imagen de la factura
        if (!empty($_FILES['factura']['tmp_name'])) {
            $facturaNueva = file_get_contents($_FILES['factura']['tmp_name']);
        } else {
            $facturaNueva = ''; // Mantener la imagen existente
        }

        // Actualizar la factura en la base de datos
        if (actualizarFactura($MiConexion, $idFacturaModificar, $nroFactura, $importeFactura, $nuevaFecha, $nuevoDetalle, $idProveedor, $facturaNueva, $nuevoEstado)) {
            $Mensaje = 'Factura actualizada exitosamente.';
            $Estilo = 'success';
        } else {
            $Mensaje = 'Error al actualizar la factura.';
            $Estilo = 'danger';
        }
    }
}

if (isset($_POST['BotonCancelar'])) {

	$idProveedor = $proveedorAModificar['IDPROVEEDOR'];
    $idEmail = $proveedorAModificar['IDEMAIL'];
    $idTelefono = $proveedorAModificar['IDTELEFONO'];
    $idDomicilio = $proveedorAModificar['IDDOMICILIO'];

    if (eliminarProveedor($MiConexion, $idProveedor, $idEmail, $idTelefono, $idDomicilio)) {
        $Mensaje = 'Se ha eliminado el proveedor.';
        $Estilo = 'success';
        // Redirigir a la lista compras después de la cancelacion exitosa
        header('Location: listado_proveedores.php');
        exit;
    } else {
        $Mensaje = 'Error al el eliminar el proveedor.';
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
	                            <h5 class="m-b-10">Administración de Compras</h5>
	                        </div>
	                        <ul class="breadcrumb">
	                            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
	                            <li class="breadcrumb-item"><a href="#!">Compras</a></li>
	                            <li class="breadcrumb-item">Modificar Factura</li>
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
                        <h5>Modificar Factura</h5>
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
                          <label for="nroFactura" class="form-label">Número de factura (*)</label>
                          <input type="text" class="form-control" id="nroFactura" placeholder="Ingresa el número de la factura a registrar" name="nroFactura" value="<?php echo $nroFactura; ?>">
                        </div>

                        <div class="mb-3">
                          <label for="importeFactura" class="form-label">Importe total (*)</label>
                          <input type="text" class="form-control" id="importeFactura" placeholder="Ingresa el importe" name="importeFactura" value="<?php echo $importeFactura; ?>">
                        </div>

                        <div class="mb-3">
						    <label for="detalleFactura" class="form-label">Detalle factura</label>
						    <textarea class="form-control" id="detalleFactura" name="detalleFactura" rows="4"><?php echo $detalleFactura; ?></textarea>
						</div>

                        <div class="mb-3">
                            <label for="factura" class="form-label">Subir y reemplazar factura cargada</label>
                            <input type="file" class="form-control" id="factura" name="factura">
                        </div>

                        <div class="mb-3">
						    <label for="factura" class="form-label">Factura</label>
						    <img src="data:image/jpeg;base64,<?php echo base64_encode($factura); ?>" class="img-fluid" alt="Factura">
						</div>

						<div class="mb-3">
						    <label for="fechaFactura" class="form-label">Fecha de la factura (*)</label>
						    <input type="text" class="form-control" id="fechaFactura" name="fechaFactura" placeholder="Selecciona la fecha de la factura" value="<?php echo $fechaFactura; ?>">
						</div>

						<div class="form-group">
						    <label for="proveedor" class="form-label">Proveedor (*)</label>
						    <select class="form-control" name="proveedor" id="proveedor">
						        <?php
						        foreach ($ListadoProveedores as $proveedor) {
						            $selected = ($proveedor['idProveedor'] == $idProveedor) ? 'selected' : '';
						            echo '<option value="' . $proveedor['idProveedor'] . '" ' . $selected . '>' . $proveedor['nombreProveedor'] . ' (ID: ' . $proveedor['idProveedor'] . ')</option>';
						        }
						        ?>
						    </select>
						</div>

						<div class="form-group">
						    <label for="estadoFactura" class="form-label">Estado factura (*)</label>
						    <select class="form-control" name="estadoFactura" id="estadoFactura">
						        <?php
						        foreach ($ListadoEstadosFactura as $estadosFactura) {
						            $selected = ($estadosFactura['idEstadoFactura'] == $idEstadoFactura) ? 'selected' : '';
						            echo '<option value="' . $estadosFactura['idEstadoFactura'] . '" ' . $selected . '>' . $estadosFactura['estadoFactura'] . ' (ID: ' . $estadosFactura['idEstadoFactura'] . ')</option>';
						        }
						        ?>
						    </select>
						</div>

                    </div>
                </div>
                <div class="col-md-12">
					<button class="btn btn-primary" type="submit" value="Guardar" name="BotonGuardar">Guardar Cambios</button>
					<button type="submit" class="btn btn-danger" name="BotonCancelar" onclick="return confirm('¿Estás seguro de que deseas eliminar esta factura?')">Eliminar factura</button>
				    <a class="btn btn-secondary" href="listado_facturas.php" role="button">Volver al listado</a>
				</div>
            </form>
        </div>
    </div>
</section>
<script>
	$('#fechaFactura').datetimepicker({
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