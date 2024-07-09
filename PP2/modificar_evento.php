<?php
session_start();

if (empty($_SESSION['Usuario_Nombre'])) {
    header('Location: cerrarsesion.php');
    exit;
}

require_once 'funciones/conexion.php';
$MiConexion = ConexionBD();

require_once 'funciones/select_eventos.php';
require_once 'funciones/validaciones.php';

$Mensaje = '';
$Estilo = 'warning';

require_once 'funciones/buscarEventoPorId.php';
require_once 'funciones/actualizarEvento.php';
require_once 'funciones/eliminarEvento.php';

if (isset($_GET['id'])) {
    // Obtener el ID del evento seleccionado desde la URL
    $idEventoModificar = $_GET['id'];

    // Verificar que el ID del evento no esté vacío o sea un valor no válido
    if (empty($idEventoModificar) || !is_numeric($idEventoModificar)) {
        // Si el ID es inválido, redirigir a la página principal o mostrar un mensaje de error
        header('Location: listado_eventos.php');
        exit;
    }

// Cargar los datos del evento seleccionado desde la base de datos
$eventoAModificar = ObtenerEventoPorId($MiConexion, $idEventoModificar);

$fechaEvento = date('d/m/y', strtotime($eventoAModificar['FECHAEVENTO']));

if (empty($eventoAModificar)) {
    // Si no se encontró el evento para modificar, redirigir al listado de eventos
    header('Location: listado_eventos.php');
    exit;
}
} else {
    // Si no se recibió el parámetro 'id' en la URL, redirigir a la página principal o mostrar un mensaje de error
    header('Location: index.php');
    exit;
}

if (!empty($_POST['BotonEliminar'])) {

    // Llamada a la función EliminarEvento pasando el id del evento a eliminar
    if (eliminarEventoPorId($MiConexion, $idEventoModificar)) {
        $Mensaje = 'Se ha eliminado correctamente el evento.';
        $Estilo = 'success';
        header('Location: listado_eventos.php');
    	exit;
    } else {
        $Mensaje = 'Error al eliminar el evento.';
        $Estilo = 'danger';
    }
}

// Procesar el formulario de modificación
if (!empty($_POST['BotonGuardar'])) {
    // Estoy en condiciones de poder validar los datos
    $Mensaje = Validar_Modificar_Evento();
    if (empty($Mensaje)) {
        // Obtener los nuevos valores del formulario
        $nuevaFecha =$_POST['fechaEvento'];
        $nuevoDetalle = $_POST['detalleEvento'];

        // Actualizar el evento en la base de datos
        ActualizarEvento($MiConexion, $idEventoModificar, $nuevaFecha, $nuevoDetalle);

        // Redirigir al listado de eventos con un mensaje de éxito
        header('Location: listado_eventos.php?mensaje=Evento actualizado exitosamente.&estilo=success');
        exit;
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
        <!-- Aquí va el código HTML para la sección de contenido -->
        <div class="card-body table-border-style">
            <h5>Modificar Evento</h5>
            <hr>
            <?php require_once 'alertas.inc.php'; ?>

            <form role="form" method="post">
                <div class="row">
                    <div class="col-md-6">

					    <div class="mb-3">
						    <label for="fechaEvento" class="form-label">Fecha del evento (*)</label>
						    <input type="text" class="form-control" id="fechaEvento" name="fechaEvento" placeholder="Selecciona la fecha del evento" value="<?php echo $fechaEvento; ?>">
						</div>

					    <div class="mb-3">
					        <label for="detalleEvento" class="form-label">Detalle del evento (*)</label>
					        <input type="text" class="form-control" id="detalleEvento" name="detalleEvento" value="<?php echo $eventoAModificar['DETALLEEVENTO']; ?>">
					    </div>
					</div>
                </div>
                <div class="col-md-12">
					<button class="btn btn-primary" type="submit" value="Guardar" name="BotonGuardar">Guardar Cambios</button>
				    <button class="btn btn-danger" type="submit" name="BotonEliminar" onclick="return confirm('¿Estás seguro de que deseas eliminar este evento?')">Eliminar Evento</button>
				    <input type="hidden" name="BotonEliminar" value="1">
				    <a class="btn btn-secondary" href="listado_eventos.php" role="button">Cancelar</a>
				</div>
            </form>
        </div>
    </div>
</section>
<script>
    $('#fechaEvento').datetimepicker({
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