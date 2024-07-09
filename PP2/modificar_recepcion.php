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
require_once 'funciones/actualizarRecepcion.php';
require_once 'funciones/cambiarEstado_recepcion.php';

require_once 'funciones/select_comprasList.php';
$ListadoCompras = ObtenerListaCompras($MiConexion);

require_once 'funciones/select_estadosRecepcionList.php';
$ListadoEstados = ObtenerListaEstadosRecepcion($MiConexion);

require_once 'funciones/select_bebidas.php';
$ListadoBebidas = Listar_Bebidas($MiConexion);
$CantidadBebidas = count($ListadoBebidas);

if (isset($_GET['id'])) {
    // Obtener el ID de la recepción seleccionada desde la URL
    $idRecepcionModificar = $_GET['id'];

    // Verificar que el ID de la recepción no esté vacío o sea un valor no válido
    if (empty($idRecepcionModificar) || !is_numeric($idRecepcionModificar)) {
        // Si el ID es inválido, redirigir a la página principal o mostrar un mensaje de error
        header('Location: listado_recepciones.php');
        exit;
    }

    // Cargar los datos de la recepción seleccionada desde la base de datos
    $recepcionAModificar = ObtenerRecepcionPorId($MiConexion, $idRecepcionModificar);

    if (empty($recepcionAModificar)) {
	    // Si no se encontró la recepcion para modificar, redirigir al listado de recepciones
	    header('Location: listado_recepciones.php');
	    exit;
	}

	$idRecepcionCompra = $recepcionAModificar['IDRECEPCIONCOMPRA'];
	$estadoRecepcion = $recepcionAModificar['ESTADORECEPCION'];
	$idEstadoRecepcion = $recepcionAModificar['IDESTADORECEPCION'];
	$fechaRecepcionCompra = date('d/m/y', strtotime($recepcionAModificar['FECHARECEPCIONCOMPRA']));
	$idCompra = $recepcionAModificar['IDCOMPRA'];
	$detalleRecepcion = $recepcionAModificar['DETALLERECEPCION'];
	$idRemito = $recepcionAModificar['IDREMITO'];
	$detalleRemito = $recepcionAModificar['DETALLEREMITO'];
	$nroRemito = $recepcionAModificar['NROREMITO'];
	$remito = $recepcionAModificar['REMITO'];
	$fechaRemito = date('d/m/y', strtotime($recepcionAModificar['FECHAREMITO']));
	$detalleMercaderia = $recepcionAModificar['DETALLEMERCADERIA'];

} else {
    // Si no se recibió el parámetro 'id' en la URL, redirigir a la página principal o mostrar un mensaje de error
    header('Location: index.php');
    exit;
}

// Procesar el formulario de modificación
if (!empty($_POST['BotonGuardar'])) {
    // Estoy en condiciones de poder validar los datos
    $Mensaje='';
    $Mensaje = Validar_Datos_Modificar_Recepcion();
    if (empty($Mensaje)) {
        // Obtener los nuevos valores del formulario
		$idEstadoRecepcion = $_POST['estadoRecepcion'];
		$fechaRecepcionCompra = $_POST['fechaRecepcion'];
		$idCompra = $_POST['compra'];
		$detalleRecepcion = $_POST['detalleRecepcion'];
		$detalleRemito = $_POST['detalleRemito'];
		$nroRemito = $_POST['nroRemito'];
		$fechaRemito = $_POST['fechaRemito'];

		// Manejar la actualización de la imagen del remito si es necesario
        if (!empty($_FILES['remito']['tmp_name'])) {
            $remito = file_get_contents($_FILES['remito']['tmp_name']);
        } else {
            $remito = ''; // Mantener la imagen existente
        }

        // Actualizar la compra en la base de datos
        if (actualizarRecepcion($MiConexion, $idRecepcionModificar, $idEstadoRecepcion, $fechaRecepcionCompra, $idCompra, $detalleRecepcion, $detalleRemito, $nroRemito, $remito, $fechaRemito, $idRemito)) {
            $Mensaje = 'Recepción actualizada exitosamente.';
            $Estilo = 'success';
        } else {
            $Mensaje = 'Error al actualizar la recepción.';
            $Estilo = 'danger';
        }
    }
}

// Procesar el formulario de modificación
if (!empty($_POST['BotonModificarMercaderia'])) {
    // Estoy en condiciones de poder validar los datos
     echo "Se ha presionado el botón para modificar mercadería";
    $Mensaje='';
    $Mensaje = Validar_Datos_Modificar_Recepcion();
    if (empty($Mensaje)) {
        // Obtener los nuevos valores del formulario
		$idEstadoRecepcion = $_POST['estadoRecepcion'];
		$fechaRecepcionCompra = $_POST['fechaRecepcion'];
		$idCompra = $_POST['compra'];
		$detalleRecepcion = $_POST['detalleRecepcion'];
		$detalleRemito = $_POST['detalleRemito'];
		$nroRemito = $_POST['nroRemito'];
		$fechaRemito = $_POST['fechaRemito'];

		// Manejar la actualización de la imagen del remito si es necesario
        if (!empty($_FILES['remito']['tmp_name'])) {
            $remito = file_get_contents($_FILES['remito']['tmp_name']);
        } else {
            $remito = ''; // Mantener la imagen existente
        }

        // Actualizar la compra en la base de datos
        if (actualizarRecepcion($MiConexion, $idRecepcionModificar, $idEstadoRecepcion, $fechaRecepcionCompra, $idCompra, $detalleRecepcion, $detalleRemito, $nroRemito, $remito, $fechaRemito, $idRemito)) {
            $Mensaje = 'Recepción actualizada exitosamente.';
            $Estilo = 'success';

            header('Location: restar_bebidas.php?id=' . $idRecepcionCompra);
        	exit;
        } else {
            $Mensaje = 'Error al actualizar la recepción.';
            $Estilo = 'danger';
        }
    }
}

if (isset($_POST['BotonCancelar'])) {
    if (cancelarRecepcion($MiConexion, $idRecepcionModificar)) {
        $Mensaje = 'Se ha cancelado correctamente la recepción.';
        $Estilo = 'success';
        // Redirigir a la lista recepciónes después de la cancelacion exitosa
        header('Location: listado_recepciones.php');
        exit;
    } else {
        $Mensaje = 'Error al cancelar la recepción.';
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
	                            <li class="breadcrumb-item"><a href="#!">Recepciones</a></li>
	                            <li class="breadcrumb-item">Modificar recepción de compra</li>
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
                        <h5>Modificar recepción de compra</h5>
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
                                <h3>| Remito</h3><span> Modifica la información asociada al remito</span><hr>
                            </div>

                            <div class="mb-3">
                                <label for="nroRemito" class="form-label">Número de remito (*)</label>
                                <input type="text" class="form-control" id="nroRemito" name="nroRemito" placeholder="Ingrese el número del remito" value="<?php echo $nroRemito; ?>">
                            </div>

                            <div class="mb-3">
                                <label for="fechaRemito" class="form-label">Fecha de remito (*)</label>
                                <input type="text" class="form-control" id="fechaRemito" name="fechaRemito" placeholder="Selecciona la fecha que figura en el remito" value="<?php echo $fechaRemito; ?>">
                            </div>

                            <div class="mb-3">
                                <label for="remito" class="form-label">Reemplazar remito</label>
                                <input type="file" class="form-control" id="remito" name="remito">
                            </div>

                            <div class="mb-3">
							    <label for="remito" class="form-label">Remito cargado</label>
							    <img src="data:image/jpeg;base64,<?php echo base64_encode($remito); ?>" class="img-fluid" alt="Remito">
							</div>

                            <div class="mb-3">
                                <label for="detalleRemito" class="form-label">Detalle del remito</label>
                                <textarea class="form-control" id="detalleRemito" name="detalleRemito" rows="4"><?php echo $detalleRemito ?></textarea>
                            </div>

                            <div class="mb-3">
                                </br></br>
                                <h3>| Recepción</h3><span> Modifica los detalles de la recepción de mercadería</span><hr>
                            </div>

                            <div class="mb-3">
                                <label for="fechaRecepcion" class="form-label">Fecha de recepción (*)</label>
                                <input type="text" class="form-control" id="fechaRecepcion" name="fechaRecepcion" placeholder="Selecciona la fecha de recepción" value="<?php echo $fechaRecepcionCompra; ?>">
                            </div>

                            <div class="mb-3">
                                <label for="detalleRecepcion" class="form-label">Detalle recepción de compra</label>
                                <textarea class="form-control" id="detalleRecepcion" name="detalleRecepcion" rows="4"><?php echo $detalleRecepcion ?></textarea>
                            </div>

                            <div class="form-group">
                                <label for="estadoRecepcion" class="form-label">Estado de la recepción (*)</label>
                                <select class="form-control" name="estadoRecepcion" id="estadoRecepcion">
                                    <option value="">Seleccionar estado</option>
                                    <?php
                                    foreach ($ListadoEstados as $estado) {
                                    	$selected = ($estado['IDESTADORECEPCION'] == $idEstadoRecepcion) ? 'selected' : '';
                                        echo '<option value="' . $estado['IDESTADORECEPCION'] . '" ' . $selected . '>' . ' Estado: ' . $estado['ESTADORECEPCION'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="compra" class="form-label">Compra por la cual recepcionamos (*)</label>
                                <select class="form-control" name="compra" id="compra">
                                    <option value="">Seleccionar compra</option>
                                    <?php
                                    foreach ($ListadoCompras as $compra) {
                                    	$selected = ($compra['IDCOMPRA'] == $idCompra) ? 'selected' : '';
                                        echo '<option value="' . $compra['IDCOMPRA'] . '" ' . $selected . '>' . ' ID: ' . $compra['IDCOMPRA'] . ' | Fecha de compra: ' . $compra['FECHACOMPRA'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                </br></br>
                                <h3>| Mercadería</h3><span> En la presente recepción se ingresó la siguiente mercadería:</span><hr>
                            </div>

                            <div class="mb-3">
                            	<span>Si observas errores en la carga de mercadería, presiona "Guardar cambios y modificar mercadería"</span>
                                <textarea class="form-control" id="detalleMercaderia" name="detalleMercaderia" rows="4"><?php echo $detalleMercaderia ?></textarea>
                            </div>

                    </div>
                </div>
                <div class="col-md-12">

					<button class="btn btn-primary" type="submit" value="BotonGuardar" name="BotonGuardar">Guardar Cambios</button>

			        <!-- Botón para "Guardar cambios y modificar mercadería" -->
			        <button type="submit" class="btn btn-primary" name="BotonModificarMercaderia">Guardar Cambios y Modificar Mercadería</button>
			        <input type="hidden" name="BotonModificarMercaderia" value="1">

					<button type="submit" class="btn btn-danger" name="BotonCancelar" onclick="return confirm('¿Estás seguro de que deseas cancelar esta recepción?')">Cancelar recepción</button>
				    <a class="btn btn-secondary" href="listado_recepciones.php" role="button">Volver al listado</a>
				</div>
            </form>
        </div>
    </div>
</section>
<script>
	$('#fechaRecepcion, #fechaRemito').datetimepicker({
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