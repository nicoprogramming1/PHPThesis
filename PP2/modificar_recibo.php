<?php
session_start();

if (empty($_SESSION['Usuario_Nombre'])) {
    header('Location: cerrarsesion.php');
    exit;
}

require_once 'funciones/conexion.php';
$MiConexion = ConexionBD();

require_once 'funciones/select_recibos.php';
require_once 'funciones/validaciones.php';

$Mensaje = '';
$Estilo = 'warning';

require_once 'funciones/buscarReciboPorId.php';
require_once 'funciones/eliminarRecibo.php';
require_once 'funciones/actualizarRecibo.php';

require_once 'funciones/select_compras.php';
$ListadoCompras = Listar_Compras($MiConexion);

if (isset($_GET['id'])) {
    // Obtener el ID del recibo seleccionado desde la URL
    $idReciboModificar = $_GET['id'];

    // Verificar que el ID del recibo no esté vacío o sea un valor no válido
    if (empty($idReciboModificar) || !is_numeric($idReciboModificar)) {
        // Si el ID es inválido, redirigir a la página principal o mostrar un mensaje de error
        header('Location: listado_recibos.php');
        exit;
    }

// Cargar los datos del recibo seleccionada desde la base de datos
$reciboAModificar = ObtenerReciboPorId($MiConexion, $idReciboModificar);

if (empty($reciboAModificar)) {
    // Si no se encontró el recibo para modificar, redirigir al listado de recibos
    header('Location: listado_recibos.php');
    exit;
}

$nroRecibo = $reciboAModificar['NRORECIBO'];
$detalleRecibo = $reciboAModificar['DETALLERECIBO'];
$recibo = $reciboAModificar['RECIBO'];
$fechaRecibo = date('d/m/y', strtotime($reciboAModificar['FECHARECIBO']));
$idCompra = $reciboAModificar['IDCOMPRA'];

} else {
    // Si no se recibió el parámetro 'id' en la URL, redirigir a la página principal o mostrar un mensaje de error
    header('Location: index.php');
    exit;
}

// Procesar el formulario de modificación
if (!empty($_POST['BotonGuardar'])) {
    // Estoy en condiciones de poder validar los datos
    $Mensaje = Validar_Datos_Modificar_Recibo();
    if (empty($Mensaje)) {
        // Obtener los nuevos valores del formulario
        $nroRecibo = $_POST['nroRecibo'];
        $detalleRecibo = $_POST['detalleRecibo'];
        $fechaRecibo = $_POST['fechaRecibo'];
        $idCompra = $_POST['idCompra'];

        // Manejar la actualización de la imagen del recibo si es necesario
        if (!empty($_FILES['recibo']['tmp_name'])) {
            $reciboNuevo = file_get_contents($_FILES['recibo']['tmp_name']);
        } else {
            $reciboNuevo = ''; // Mantener la imagen existente
        }

        // Actualizar el recibo en la base de datos
        if (actualizarRecibo($MiConexion, $idReciboModificar, $nroRecibo, $fechaRecibo, $detalleRecibo, $idCompra, $reciboNuevo)) {
            $Mensaje = 'Recibo actualizado exitosamente.';
            $Estilo = 'success';
        } else {
            $Mensaje = 'Error al actualizar el recibo.';
            $Estilo = 'danger';
        }
    }
}

if (isset($_POST['BotonCancelar'])) {

	$nroRecibo = $reciboAModificar['NRORECIBO'];
	$detalleRecibo = $reciboAModificar['DETALLERECIBO'];
	$recibo = $reciboAModificar['RECIBO'];
	$fechaRecibo = date('d/m/y', strtotime($reciboAModificar['FECHARECIBO']));
	$idCompra = $reciboAModificar['IDCOMPRA'];

    if (eliminarRecibo($MiConexion, $idReciboModificar)) {
        $Mensaje = 'Se ha eliminado el recibo.';
        $Estilo = 'success';
        // Redirigir a la lista recibos después de la cancelacion exitosa
        header('Location: listado_recibos.php');
        exit;
    } else {
        $Mensaje = 'Error al eliminar el recibo.';
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
	                            <li class="breadcrumb-item">Modificar Recibo</li>
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
                        <h5>Modificar Recibo</h5>
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
                          <label for="nroRecibo" class="form-label">Número de recibo (*)</label>
                          <input type="text" class="form-control" id="nroRecibo" placeholder="Ingresa el número del recibo a registrar" name="nroRecibo" value="<?php echo $nroRecibo; ?>">
                        </div>

                        <div class="mb-3">
                            <label for="detalleRecibo" class="form-label">Detalle recibo</label>
                            <textarea class="form-control" id="detalleRecibo" name="detalleRecibo" rows="4"><?php echo $detalleRecibo; ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="recibo" class="form-label">Cargar recibo (*)</label>
                            <input type="file" class="form-control" id="recibo" name="recibo">
                        </div>

						<div class="mb-3">
                            <label class="form-label">Recibo</label></br>
                            <?php
                            $imagenCodificada = $reciboAModificar['RECIBO'];
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
                            <label for="fechaRecibo" class="form-label">Fecha del recibo (*)</label>
                            <input type="text" class="form-control" id="fechaRecibo" name="fechaRecibo" placeholder="Selecciona la fecha del recibo" value="<?php echo $fechaRecibo; ?>">
                        </div>

                        <div class="form-group">
                            <label for="idCompra" class="form-label">Compra (*)</label>
                            <select class="form-control" name="idCompra" id="idCompra">
							    <option value="">Seleccionar compra</option>
							    <?php
							    foreach ($ListadoCompras as $compra) {
							        // Comprueba si el ID de la compra coincide con el ID de la compra asociada al recibo que estás modificando
							        $selected = ($compra['IDCOMPRA'] == $idCompra) ? 'selected' : '';
							        echo '<option value="' . $compra['IDCOMPRA'] . '" ' . $selected . '>NroFactura: ' . $compra['NROFACTURA'] . ' | ID compra: ' . $compra['IDCOMPRA'] . ' | Fecha:  ' . $compra['FECHACOMPRA'] . '</option>';
							    }
							    ?>
							</select>
                        </div>
                    </div>

                    </div>
                </div>
                <div class="col-md-12">
					<button class="btn btn-primary" type="submit" value="Guardar" name="BotonGuardar">Guardar Cambios</button>
					<button type="submit" class="btn btn-danger" name="BotonCancelar" onclick="return confirm('¿Estás seguro de que deseas eliminar este recibo?')">Eliminar recibo</button>
				    <a class="btn btn-secondary" href="listado_recibos.php" role="button">Volver al listado</a>
				</div>
            </form>
        </div>
    </div>
</section>
<script>
	$('#fechaRecibo').datetimepicker({
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