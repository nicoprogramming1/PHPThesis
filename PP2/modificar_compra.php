<?php
session_start();

if (empty($_SESSION['Usuario_Nombre'])) {
    header('Location: cerrarsesion.php');
    exit;
}

require_once 'funciones/conexion.php';
$MiConexion = ConexionBD();

require_once 'funciones/select_compras.php';
require_once 'funciones/validaciones.php';

$Mensaje = '';
$Estilo = 'warning';

require_once 'funciones/buscarCompraPorId.php';
require_once 'funciones/actualizarCompra.php';
require_once 'funciones/cambiarEstado_compra.php';

require_once 'funciones/select_ordenesCompraList.php';
$ListadoOrdenesCompra = ObtenerListaOrdenesCompra($MiConexion);

require_once 'funciones/select_facturasList.php';
$ListadoFacturas = ObtenerListaFacturas($MiConexion);

$fechaEntregaPrevista = '';
$detalleCompra = '';
$idOrdenCompra = '';
$factura = '';

if (isset($_GET['id'])) {
    // Obtener el ID de la compra seleccionado desde la URL
    $idCompraModificar = $_GET['id'];

    // Verificar que el ID de la compra no esté vacío o sea un valor no válido
    if (empty($idCompraModificar) || !is_numeric($idCompraModificar)) {
        // Si el ID es inválido, redirigir a la página principal o mostrar un mensaje de error
        header('Location: listado_compras.php');
        exit;
    }

    // Cargar los datos de la compra seleccionada desde la base de datos
    $compraAModificar = ObtenerCompraPorId($MiConexion, $idCompraModificar);

    if (!empty($compraAModificar)) {
        $fechaEntregaPrevista = date('d/m/y', strtotime($compraAModificar['fechaEntregaPrevista']));
        $detalleCompra = $compraAModificar['detalleCompra'];
        $idOrdenCompra = $compraAModificar['idOrdenCompra'];
        $factura = $compraAModificar['idFactura'];
    } else {
        // Si no se encontró la compra para modificar, redirigir al listado de compras
        header('Location: listado_compras.php');
        exit;
    }
} else {
    // Si no se recibió el parámetro 'id' en la URL, redirigir a la página principal o mostrar un mensaje de error
    header('Location: index.php');
    exit;
}

// Procesar el formulario de modificación
if (!empty($_POST['BotonGuardar'])) {
    // Estoy en condiciones de poder validar los datos
    $Mensaje = Validar_Datos_Modificar_Compra();
    if (empty($Mensaje)) {
        // Obtener los nuevos valores del formulario
        $fechaEntregaPrevista = $_POST['fechaEntregaPrevista'];
        $detalleCompra = $_POST['detalleCompra'];
        $idOrdenCompra = $_POST['ordenCompra'];
        $factura = $_POST['factura'];

        // Actualizar la compra en la base de datos
        if (actualizarCompra($MiConexion, $idCompraModificar, $fechaEntregaPrevista, $detalleCompra, $idOrdenCompra, $factura)) {
            $Mensaje = 'Compra actualizada exitosamente.';
            $Estilo = 'success';
        } else {
            $Mensaje = 'Error al actualizar la compra.';
            $Estilo = 'danger';
        }
    }
}

if (isset($_POST['BotonCancelar'])) {
    if (cancelarCompra($MiConexion, $idCompraModificar)) {
        $Mensaje = 'Se ha cancelado correctamente la compra.';
        $Estilo = 'success';
        // Redirigir a la lista compras después de la cancelacion exitosa
        header('Location: listado_compras.php');
        exit;
    } else {
        $Mensaje = 'Error al cancelar la compra.';
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
	                            <li class="breadcrumb-item">Modificar Compra</li>
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
                        <h5>Modificar Compra</h5>
                        <hr>
                        <?php require_once 'alertas.inc.php'; ?>

                        <div class="alert alert-info" role="alert">
                        <i data-feather="info"></i> 
							Los campos con * son obligatorios. 
						</div>

            <form role="form" method="post">
                <div class="row">
                    <div class="col-md-6">

                  			<div class="mb-3">
						        <label for="detalleCompra" class="form-label">Detalle compra</label>
						        <textarea class="form-control" id="detalleCompra" name="detalleCompra" rows="4"><?php echo $detalleCompra; ?></textarea>
						    </div>

							<div class="mb-3">
							    <label for="fechaEntregaPrevista" class="form-label">Fecha de entrega prevista</label>
							    <input type="text" class="form-control" id="fechaEntregaPrevista" name="fechaEntregaPrevista" placeholder="Selecciona la fecha de entrega prevista por la compra" value="<?php echo $fechaEntregaPrevista; ?>">
							</div>

							<div class="form-group">
							    <label for="factura" class="form-label">Factura (*)</label>
							    <select class="form-control" name="factura" id="factura">
							        <option value="">Seleccionar factura</option>
							        <?php
							        foreach ($ListadoFacturas as $facturaItem) {
							            $selected = ($facturaItem['idFactura'] == $factura) ? 'selected' : '';
							            echo '<option value="' . $facturaItem['idFactura'] . '" ' . $selected . '>' . ' N° factura: ' . $facturaItem['nroFactura'] . ' | Proveedor: ' . $facturaItem['nombreProveedor'] . ' | ' . $facturaItem['fechaFactura'] . '</option>';
							        }
							        ?>
							    </select>
							</div>

							<div class="form-group">
							    <label for="ordenCompra" class="form-label">Orden de compra (*)</label>
							    <select class="form-control" name="ordenCompra" id="ordenCompra">
							        <option value="">Seleccionar orden de compra</option>
							        <?php
							        foreach ($ListadoOrdenesCompra as $ordenCompra) {
							            $selected = ($ordenCompra['idOrdenCompra'] == $idOrdenCompra) ? 'selected' : '';
							            echo '<option value="' . $ordenCompra['idOrdenCompra'] . '" ' . $selected . '>' . ' ID: ' . $ordenCompra['idOrdenCompra'] . ' | Proveedor: ' . $ordenCompra['nombreProveedor'] . ' | ' . $ordenCompra['fechaEnvio'] . '</option>';
							        }
							        ?>
							    </select>
							</div>

                    </div>
                </div>
                <div class="col-md-12">
					<button class="btn btn-primary" type="submit" value="Guardar" name="BotonGuardar">Guardar Cambios</button>
					<button type="submit" class="btn btn-danger" name="BotonCancelar" onclick="return confirm('¿Estás seguro de que deseas cancelar esta compra?')">Cancelar compra</button>
				    <a class="btn btn-secondary" href="listado_compras.php" role="button">Volver al listado</a>
				</div>
            </form>
        </div>
    </div>
</section>
<script>
	$('#fechaEntregaPrevista').datetimepicker({
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