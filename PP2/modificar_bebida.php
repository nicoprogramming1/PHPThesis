<?php
session_start();

if (empty($_SESSION['Usuario_Nombre'])) {
    header('Location: cerrarsesion.php');
    exit;
}

require_once 'funciones/conexion.php';
$MiConexion = ConexionBD();

require_once 'funciones/select_bebidas.php';
require_once 'funciones/validaciones.php';

$Mensaje = '';
$Estilo = 'warning';

require_once 'funciones/buscarBebidaPorId.php';
require_once 'funciones/actualizarBebida.php';
require_once 'funciones/eliminarBebida.php';

require_once 'funciones/select_marcas.php';
$ListadoMarcas = Listar_Marcas($MiConexion);

require_once 'funciones/select_volumenes.php';
$ListadoVolumenes = Listar_Volumenes($MiConexion);

$bebidaAModificar = array();

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    // Obtener el ID de la bebida seleccionado desde la URL
    $idBebidaAModificar = $_GET['id'];

    // Cargar los datos de la bebida seleccionado desde la base de datos
    $bebidaAModificar = ObtenerBebidaPorId($MiConexion, $idBebidaAModificar);

    // Verificar que el ID de la bebida no esté vacío o sea un valor no válido
    if (empty($bebidaAModificar)) {
        // Si el ID es inválido, redirigir a la página principal o mostrar un mensaje de error
        header('Location: listado_bebidas.php');
        exit;
    }
}

// Procesar el formulario de modificación
if (!empty($_POST['BotonGuardar'])) {
    // Estoy en condiciones de poder validar los datos
    $Mensaje = Validar_Datos_Modificar_Bebida();
    if (empty($Mensaje)) {
        // Obtener los nuevos valores del formulario
        $bebida = $_POST['bebida'];
        $marca = $_POST['marca'];
        $volumen = $_POST['volumen'];

        // Actualizar el proveedor en la base de datos
        if (actualizarBebida($MiConexion, $idBebidaAModificar, $bebida, $marca, $volumen)) {
            $Mensaje = 'Bebida actualizada exitosamente.';
            $Estilo = 'success';
        } else {
            $Mensaje = 'Error al actualizar la bebida.';
            $Estilo = 'danger';
        }
    }
}

if (isset($_POST['BotonCancelar'])) {

    if (eliminarBebida($MiConexion, $idBebidaAModificar)) {
        $Mensaje = 'Se ha eliminado la bebida.';
        $Estilo = 'success';
        // Redirigir a la lista bebidas después de la cancelacion exitosa
        header('Location: listado_bebidas.php');
        exit;
    } else {
        $Mensaje = 'Error al eliminar la bebida.';
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
	                            <li class="breadcrumb-item"><a href="#!">Stock</a></li>
	                            <li class="breadcrumb-item">Modificar bebida</li>
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
                        <h5>Modificar bebida</h5>
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
                                  <label for="bebida" class="form-label">Nombre bebida (*)</label>
                                  <input type="text" class="form-control" id="bebida" placeholder="Ingresa el nombre de la bebida" name="bebida" value="<?php echo $bebidaAModificar['BEBIDA']; ?>">
                                </div>

                                <div class="form-group">
                                    <label for="marca" class="form-label">Marca (*)</label>
                                    <select class="form-control" name="marca" id="marca">
                                        <option value="">Seleccionar marca</option>
                                        <?php
                                        foreach ($ListadoMarcas as $marca) {
                                        	$selected = ($marca['IDMARCA'] == $bebidaAModificar['IDMARCA']) ? 'selected' : '';
                                            echo '<option value="' . $marca['IDMARCA'] . '" ' . $selected . '>' . $marca['MARCA'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="volumen" class="form-label">Volumen (*)</label>
                                    <select class="form-control" name="volumen" id="volumen">
                                        <option value="">Seleccionar volumen</option>
                                        <?php
                                        foreach ($ListadoVolumenes as $volumen) {
                                        	$selected = ($volumen['IDVOLUMEN'] == $bebidaAModificar['IDVOLUMEN']) ? 'selected' : '';
                                            echo '<option value="' . $volumen['IDVOLUMEN'] . '" ' . $selected . '>' . $volumen['VOLUMEN'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                    </div>
                </div>
                <div class="col-md-12">
					<button class="btn btn-primary" type="submit" value="Guardar" name="BotonGuardar">Guardar Cambios</button>
					<button type="submit" class="btn btn-danger" name="BotonCancelar" onclick="return confirm('¿Estás seguro de que deseas eliminar esta bebida?')">Eliminar bebida</button>
				    <a class="btn btn-secondary" href="listado_bebidas.php" role="button">Volver al listado</a>
				</div>
            </form>
        </div>
    </div>
</section>

<?php require_once 'footer.inc.php'; ?>