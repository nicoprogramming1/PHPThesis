<?php 
session_start();

if (empty($_SESSION['Usuario_Nombre'])) {
    header('Location: cerrarsesion.php');
    exit;
}

require_once 'funciones/conexion.php';
$MiConexion=ConexionBD(); 

if (isset($_GET['id'])) {
    // Obtener el ID del rol seleccionado desde la URL
    $rolSeleccionadoID = $_GET['id'];

    // Verificar que el ID del rol no esté vacío o sea un valor no válido
    if (empty($rolSeleccionadoID) || !is_numeric($rolSeleccionadoID)) {
        // Si el ID es inválido, redirigir a la página principal o mostrar un mensaje de error
        header('Location: index.php');
        exit;
    }

    // Llamar a la función para buscar el nombre del rol por su ID
    require_once 'funciones/buscarNombreRolPorId.php';
    $nombreRolSeleccionado = buscarNombreRolPorID($MiConexion, $rolSeleccionadoID);

    // Verificar que se haya encontrado el nombre del rol
    if (empty($nombreRolSeleccionado)) {
        // Si no se encontró el nombre del rol, redirigir a la página principal o mostrar un mensaje de error
        header('Location: index.php');
        exit;
    }
} else {
    // Si no se recibió el parámetro 'id' en la URL, redirigir a la página principal o mostrar un mensaje de error
    header('Location: index.php');
    exit;
}

// Verificar si se ha enviado el formulario con el botón "Eliminar"
if (isset($_POST['BotonEliminar'])) {
    // Obtener el ID del rol seleccionado desde la URL
    $rolSeleccionadoID = $_GET['id'];

    // Verificar que el ID del rol no esté vacío o sea un valor no válido
    if (empty($rolSeleccionadoID) || !is_numeric($rolSeleccionadoID)) {
        // Si el ID es inválido, redirigir a la página principal o mostrar un mensaje de error
        header('Location: index.php');
        exit;
    }

	require_once 'funciones/eliminarRolPorId.php';

    // Eliminar el rol de la base de datos
    if (eliminarRolPorID($MiConexion, $rolSeleccionadoID)) {
        $Mensaje = 'Rol eliminado con exito';
        // Redirigir a la página principal con un mensaje de éxito
        header('Location: listado_roles.php?mensaje=El rol ha sido eliminado correctamente.');
        exit;
    } else {
        // Mostrar un mensaje de error en la página actual
        $Mensaje = 'Error al eliminar el rol.';
        $Estilo = 'danger';
    }
}


require_once 'funciones/actualizar_roles.php';
require_once 'funciones/buscarRolPorId.php';
require_once 'funciones/validaciones.php';

$Mensaje = '';
$Estilo = 'warning';
if (!empty($_POST['BotonModificar'])) {
    // Estoy en condiciones de poder validar los datos
    $Mensaje = Validar_Modificar_Roles();
    if (empty($Mensaje)) {
        // Obtener el nuevo nombre del rol desde el formulario
        $nuevoNombreRol = $_POST['nuevoNombreRol'];

        // Realizar la modificación del nombre del rol en la base de datos
        if (ModificarRol($MiConexion, $rolSeleccionadoID, $nuevoNombreRol)) {
            $Mensaje = 'Se ha modificado correctamente el nombre del rol.';
            $_POST = array();
            $Estilo = 'success';
            $nombreRolSeleccionado = "";
            // Actualizar el nombre del rol seleccionado con el nuevo nombre en la variable para mostrar en el formulario
            $rolSeleccionado['NOMBRE'] = $nuevoNombreRol;
        } else {
            $Mensaje = 'Error al modificar el nombre del rol.';
            $Estilo = 'danger';
        }
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
                            <h5 class="m-b-10">Roles</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item"><a href="#!">Rol</a></li>
                        </ul>

                        <?php require_once 'alertas.inc.php'; ?>


			                            <div class="card-body">

                	<form role="form" method="post">
		                <div class="row">
		                    <div class="col-md-6">
		                        <div class="form-group">
		                            <label for="nuevoNombreRol">Nombre del Rol</label>
		                            <input type="text" class="form-control" id="nuevoNombreRol" name="nuevoNombreRol" value="<?php echo $nombreRolSeleccionado; ?>" required>
		                        </div>
		                    </div>
		                    <div class="col-md-12">
		                        <button class="btn btn-primary" type="submit" value="Modificar" name="BotonModificar">
		                            Modificar
		                        </button>
		                        <button class="btn btn-danger" type="submit" name="BotonEliminar" onclick="return confirm('¿Estás seguro de que deseas eliminar este rol?')">Eliminar</button>
		                        <input class="btn btn-secondary" type="reset" value="Resetear datos" name="BotonLimpiar">
		                        <a class="btn btn-light" href="listado_roles.php" role="button">Volver</a>
		                    </div>
		                </div>
		            </form>
			                               
			                            </div>
			                        </div>
			            </div>
			        </div>
			    </section>
			    <!-- ... Tu código para el pie de página ... -->
			    <?php require_once 'footer.inc.php'; ?>
