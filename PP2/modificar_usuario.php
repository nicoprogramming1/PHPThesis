<?php
session_start();

if (empty($_SESSION['Usuario_Nombre'])) {
    header('Location: cerrarsesion.php');
    exit;
}

require_once 'funciones/conexion.php';
$MiConexion = ConexionBD();

require_once 'funciones/select_roles.php';
require_once 'funciones/validaciones.php';

$Mensaje = '';
$Estilo = 'warning';

require_once 'funciones/buscarRolPorId.php';
require_once 'funciones/buscarUsuarioPorId.php';
require_once 'funciones/actualizarUsuario.php';
require_once 'funciones/eliminarUsuario.php';

require_once 'funciones/select_roles.php';
$ListadoRoles = ListarRoles($MiConexion);

if (isset($_GET['id'])) {
    // Obtener el ID del usuario seleccionado desde la URL
    $idUsuarioModificar = $_GET['id'];

    // Verificar que el ID del usuario no esté vacío o sea un valor no válido
    if (empty($idUsuarioModificar) || !is_numeric($idUsuarioModificar)) {
        // Si el ID es inválido, redirigir a la página principal o mostrar un mensaje de error
        header('Location: listado_usuarios.php');
        exit;
    }

// Cargar los datos de la factura seleccionada desde la base de datos
$usuarioAModificar = ObtenerUsuarioPorId($MiConexion, $idUsuarioModificar);

if (empty($usuarioAModificar)) {
    // Si no se encontró la factura para modificar, redirigir al listado de facturas
    header('Location: listado_usuarios.php');
    exit;
}

$nombreUsuario = $usuarioAModificar['NOMBRE'];
$apellidoUsuario = $usuarioAModificar['APELLIDO'];
$email = $usuarioAModificar['EMAIL'];
$idRol = $usuarioAModificar['IDROL'];
$rol = $usuarioAModificar['ROL'];

} else {
    // Si no se recibió el parámetro 'id' en la URL, redirigir a la página principal o mostrar un mensaje de error
    header('Location: index.php');
    exit;
}

// Procesar el formulario de modificación
if (!empty($_POST['BotonGuardar'])) {
    // Estoy en condiciones de poder validar los datos
    $Mensaje = Validar_Datos_Modificar_Usuarios();
    if (empty($Mensaje)) {

        // Actualizar la factura en la base de datos
        if (actualizarUsuario($MiConexion, $idUsuarioModificar)) {
            $Mensaje = 'Usuario actualizado exitosamente.';
            $Estilo = 'success';
			header('Location: listado_usuarios.php');
        exit;
        } else {
            $Mensaje = 'Error al actualizar el usuario.';
            $Estilo = 'danger';
        }
    }
}

if (isset($_POST['BotonCancelar'])) {

    if (eliminarUsuario($MiConexion, $idUsuarioModificar)) {
        $Mensaje = 'Se ha eliminado el usuario.';
        $Estilo = 'success';
        // Redirigir a la lista usuarios después de la cancelacion exitosa
        header('Location: listado_usuarios.php');
        exit;
    } else {
        $Mensaje = 'Error al eliminar el usuario.';
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
	                            <h5 class="m-b-10">Administración de Usuarios</h5>
	                        </div>
	                        <ul class="breadcrumb">
	                            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
	                            <li class="breadcrumb-item"><a href="#!">Usuarios</a></li>
	                            <li class="breadcrumb-item">Modificar usuario</li>
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
                        <h5>Modificar Usuario</h5>
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
                          <label for="email" class="form-label">Email (*)</label>
                          <input type="email" class="form-control" id="email" placeholder="Ingresa el email" name="email" value="<?php echo $email; ?>">
                        </div>

                        <div class="mb-3">
                          <label for="clave" class="form-label">Clave (*)</label>
                          <input type="password" class="form-control" id="clave" placeholder="Ingresa la clave" name="clave">
                        </div>

                        <div class="mb-3">
						    <label for="nombre" class="form-label">Nombre (*)</label>
						    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingresa el nombre" value="<?php echo $nombreUsuario; ?>">
						</div>

						<div class="mb-3">
						    <label for="apellido" class="form-label">Apellido (*)</label>
						    <input type="text" class="form-control" id="apellido" name="apellido" placeholder="Ingresa el apellido" value="<?php echo $apellidoUsuario; ?>">
						</div>

						<div class="form-group">
						    <label for="rol" class="form-label">Rol (*)</label>
						    <select class="form-control" name="rol" id="rol">
						        <?php
						        foreach ($ListadoRoles as $rolItem) {
								    $selected = ($idRol == $rolItem['IDROL']) ? 'selected' : '';
								    echo '<option value="' . $rolItem['IDROL'] . '" ' . $selected . '>' . $rolItem['ROLES'] . ' (ID: ' . $rolItem['IDROL'] . ')</option>';
								}
						        ?>
						    </select>
						</div>

                    </div>
                </div>
                <div class="col-md-12">
					<button class="btn btn-primary" type="submit" value="Guardar" name="BotonGuardar">Guardar Cambios</button>
					<button type="submit" class="btn btn-danger" name="BotonCancelar" onclick="return confirm('¿Estás seguro de que deseas eliminar este usuario?')">Eliminar usuario</button>
				    <a class="btn btn-secondary" href="listado_usuarios.php" role="button">Volver al listado</a>
				</div>
            </form>
        </div>
    </div>
</section>

<?php require_once 'footer.inc.php'; ?>