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

require_once 'funciones/buscarReclamoPorId.php';
require_once 'funciones/actualizarReclamo.php';
require_once 'funciones/cambiarEstado_reclamo.php';

require_once 'funciones/select_proveedores.php';
$ListadoProveedores = Listar_Proveedores($MiConexion);

require_once 'funciones/select_recepcionesParaReclamos.php';
$ListadoRecepciones = Listar_Recepciones($MiConexion);

if (isset($_GET['id'])) {
    // Obtener el ID del reclamo seleccionada desde la URL
    $idReclamoModificar = $_GET['id'];

    // Verificar que el ID del reclamo no esté vacío o sea un valor no válido
    if (empty($idReclamoModificar) || !is_numeric($idReclamoModificar)) {
        // Si el ID es inválido, redirigir a la página principal o mostrar un mensaje de error
        header('Location: listado_reclamos.php');
        exit;
    }

    // Cargar los datos del reclamo seleccionada desde la base de datos
    $reclamoAModificar = ObtenerReclamoPorId($MiConexion, $idReclamoModificar);

    if (empty($reclamoAModificar)) {
	    // Si no se encontró el reclamo para modificar, redirigir al listado de recepciones
	    header('Location: listado_reclamos.php');
	    exit;
	}

	$idReclamo = $reclamoAModificar['IDRECLAMO'];
	$estadoReclamo = $reclamoAModificar['ESTADORECLAMO'];
	$idRecepcionCompra = $reclamoAModificar['IDRECEPCIONCOMPRA'];
	$fechaReclamo = date('d/m/y', strtotime($reclamoAModificar['FECHARECLAMO']));
	$fechaRecepcionCompra = date('d/m/y', strtotime($reclamoAModificar['FECHARECEPCIONCOMPRA']));
	$idProveedor = $reclamoAModificar['IDPROVEEDOR'];
	$nombreProveedor = $reclamoAModificar['PROVEEDOR'];
	$detalleReclamo = $reclamoAModificar['DETALLERECLAMO'];
	$idEstadoReclamo = $reclamoAModificar['IDESTADORECLAMO'];

} else {
    // Si no se recibió el parámetro 'id' en la URL, redirigir a la página principal o mostrar un mensaje de error
    header('Location: index.php');
    exit;
}

// Procesar el formulario de modificación
if (!empty($_POST['BotonGuardar'])) {
    // Estoy en condiciones de poder validar los datos
    $Mensaje='';
    $Mensaje = Validar_Datos_Modificar_Reclamo();
    if (empty($Mensaje)) {
        // Obtener los nuevos valores del formulario
		$detalleReclamo = $_POST['detalleReclamo'];
		$idReclamo = $_POST['recepcionCompra'];
		$idProveedor = $_POST['proveedor'];

        // Actualizar la compra en la base de datos
        if (actualizarReclamo($MiConexion, $idReclamoModificar, $detalleReclamo, $idRecepcionCompra, $idProveedor)) {
            $Mensaje = 'Reclamo actualizado exitosamente.';
            $Estilo = 'success';
        } else {
            $Mensaje = 'Error al actualizar el reclamo.';
            $Estilo = 'danger';
        }
    }
}

if (isset($_POST['BotonCancelar'])) {
    if (cancelarReclamo($MiConexion, $idReclamoModificar)) {
        $Mensaje = 'Se ha cancelado correctamente el reclamo.';
        $Estilo = 'success';
        // Redirigir a la lista de reclamos después de la cancelacion exitosa
        header('Location: listado_reclamos.php');
        exit;
    } else {
        $Mensaje = 'Error al cancelar el reclamo.';
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
	                            <h5 class="m-b-10">Administración de Stock</h5>
	                        </div>
	                        <ul class="breadcrumb">
	                            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
	                            <li class="breadcrumb-item"><a href="#!">Reclamos</a></li>
	                            <li class="breadcrumb-item">Modificar reclamo</li>
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
                        <h5>Modificar reclamo</h5>
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
                                <h3>| Reclamo</h3><span> Puedes modificar los datos del reclamo</span><hr>
                            </div>

                            <div class="mb-3">
                                <label for="detalleReclamo" class="form-label">Detalle del reclamo (*)</label>
                                <textarea class="form-control" id="detalleReclamo" name="detalleReclamo" rows="4"><?php echo $detalleReclamo ?></textarea>
                            </div>

                            <div class="form-group">
                                <label for="proveedor" class="form-label">Proveedor (*)</label>
                                <select class="form-control" name="proveedor" id="proveedor">
                                    <option value="">Seleccionar proveedor</option>
                                    <?php
                                    foreach ($ListadoProveedores as $proveedor) {
                                    	$selected = ($proveedor['IDPROVEEDOR'] == $idProveedor) ? 'selected' : '';
                                        echo '<option value="' . $proveedor['IDPROVEEDOR'] . '" ' . $selected . '>' . ' Proveedor: ' . $proveedor['NOMBREPROVEEDOR'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="recepcionCompra" class="form-label">Recepción de compra (*)</label>
                                <select class="form-control" name="recepcionCompra" id="recepcionCompra">
                                    <option value="">Seleccionar recepción de compra</option>
                                    <?php
                                    foreach ($ListadoRecepciones as $recepcion) {
                                    	$selected = ($recepcion['IDRECEPCIONCOMPRA'] == $idRecepcionCompra) ? 'selected' : '';
                                        echo '<option value="' . $recepcion['IDRECEPCIONCOMPRA'] . '" ' . $selected . '>' . ' ID: ' . $recepcion['IDRECEPCIONCOMPRA'] . ' | Fecha de recepción de compra: ' . $recepcion['FECHARECEPCIONCOMPRA'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                    </div>
                </div>
                <div class="col-md-12">

					<button class="btn btn-primary" type="submit" value="BotonGuardar" name="BotonGuardar">Guardar Cambios</button>
					<button type="submit" class="btn btn-danger" name="BotonCancelar" onclick="return confirm('¿Estás seguro de que deseas cancelar este reclamo?')">Cancelar reclamo</button>
				    <a class="btn btn-secondary" href="listado_reclamos.php" role="button">Volver al listado</a>
				</div>
            </form>
        </div>
    </div>
</section>

<?php require_once 'footer.inc.php'; ?>