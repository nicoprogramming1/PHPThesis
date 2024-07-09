<?php
session_start();

if (empty($_SESSION['Usuario_Nombre'])) {
    header('Location: cerrarsesion.php');
    exit;
}

require_once 'funciones/conexion.php';
$MiConexion = ConexionBD();

require_once 'funciones/select_proveedores.php';
require_once 'funciones/validaciones.php';

$Mensaje = '';
$Estilo = 'warning';

require_once 'funciones/buscarProveedorPorId.php';
require_once 'funciones/actualizarProveedor.php';
require_once 'funciones/eliminarProveedor.php';

require_once 'funciones/select_ciudades.php';
$ListadoCiudades = Listar_Ciudades($MiConexion);

$proveedorAModificar = array();

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    // Obtener el ID del proveedor seleccionado desde la URL
    $idProveedorAModificar = $_GET['id'];

    // Cargar los datos del proveedor seleccionado desde la base de datos
    $proveedorAModificar = ObtenerProveedorPorId($MiConexion, $idProveedorAModificar);

    // Verificar que el ID del proveedor no esté vacío o sea un valor no válido
    if (empty($proveedorAModificar)) {
        // Si el ID es inválido, redirigir a la página principal o mostrar un mensaje de error
        header('Location: listado_proveedores.php');
        exit;
    }
}

// Procesar el formulario de modificación
if (!empty($_POST['BotonGuardar'])) {
    // Estoy en condiciones de poder validar los datos
    $Mensaje = Validar_Datos_Modificar_Proveedor();
    if (empty($Mensaje)) {
        // Obtener los nuevos valores del formulario
        $nombreProveedor = $_POST['nombreProveedor'];
        $cuil = $_POST['cuil'];
        $email = $_POST['email'];
        $idEmail = $proveedorAModificar['IDEMAIL'];
        $idTelefono = $proveedorAModificar['IDTELEFONO'];
        $telefono = $_POST['telefono'];
        $idDomicilio = $proveedorAModificar['IDDOMICILIO'];
        $domicilio = $_POST['domicilio'];
        $idCiudad = $proveedorAModificar['IDCIUDAD'];
        $ciudad = $_POST['ciudad'];

        // Actualizar el proveedor en la base de datos
        if (actualizarProveedor($MiConexion, $idProveedorAModificar, $nombreProveedor, $cuil, $email, $idEmail, $telefono, $idTelefono, $domicilio, $idDomicilio, $ciudad, $idCiudad)) {
            $Mensaje = 'Proveedor actualizado exitosamente.';
            $Estilo = 'success';
        } else {
            $Mensaje = 'Error al actualizar el proveedor.';
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
	                            <h5 class="m-b-10">Administración de proveedores</h5>
	                        </div>
	                        <ul class="breadcrumb">
	                            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
	                            <li class="breadcrumb-item"><a href="#!">Proveedores</a></li>
	                            <li class="breadcrumb-item">Modificar proveedor</li>
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

							<div class="form-group">
	                            <label for="nombreProveedor">Nombre del proveedor</label>
	                            <input type="text" class="form-control" id="nombreProveedor" name="nombreProveedor" value="<?php echo $proveedorAModificar['NOMBREPROVEEDOR']; ?>">
		                    </div>

		                    <div class="form-group">
	                            <label for="cuil">CUIL</label>
	                            <input type="text" class="form-control" id="cuil" name="cuil" value="<?php echo $proveedorAModificar['CUIL']; ?>">
		                    </div>

		                    <div class="form-group">
	                            <label for="email">Email</label>
	                            <input type="text" class="form-control" id="email" name="email" value="<?php echo $proveedorAModificar['EMAIL']; ?>">
		                    </div>

		                    <div class="form-group">
	                            <label for="telefono">Telefono</label>
	                            <input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo $proveedorAModificar['TELEFONO']; ?>">
		                    </div>

		                    <div class="form-group">
	                            <label for="domicilio">Domicilio</label>
	                            <input type="text" class="form-control" id="domicilio" name="domicilio" value="<?php echo $proveedorAModificar['DOMICILIO']; ?>">
		                    </div>

							<div class="form-group">
							    <label for="ciudad" class="form-label">Ciudad (*)</label>
							    <select class="form-control" name="ciudad" id="ciudad">
                                    <option value="">Seleccionar ciudad</option>
                                    <?php
                                    foreach ($ListadoCiudades as $ciudad) {
                                        $selected = ($ciudad['IDCIUDAD'] == $proveedorAModificar['IDCIUDAD']) ? 'selected' : '';
                                        echo '<option value="' . $ciudad['IDCIUDAD'] . '" ' . $selected . '>' . $ciudad['CIUDAD'] . '</option>';
                                    }
                                    ?>
                                </select>
							</div>

                    </div>
                </div>
                <div class="col-md-12">
					<button class="btn btn-primary" type="submit" value="Guardar" name="BotonGuardar">Guardar Cambios</button>
					<button type="submit" class="btn btn-danger" name="BotonCancelar" onclick="return confirm('¿Estás seguro de que deseas eliminar este proveedor?')">Eliminar proveedor</button>
				    <a class="btn btn-secondary" href="listado_proveedores.php" role="button">Volver al listado</a>
				</div>
            </form>
        </div>
    </div>
</section>

<?php require_once 'footer.inc.php'; ?>