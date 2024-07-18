<?php 
session_start();

if (empty($_SESSION['Usuario_Nombre'])) {
    header('Location: cerrarsesion.php');
    exit;
}

require_once 'funciones/conexion.php';
$MiConexion=ConexionBD(); 

require_once 'funciones/select_roles.php';
$ListadoRoles = ListarRoles($MiConexion);
$CantidadRoles= count($ListadoRoles);


require_once 'funciones/buscarIdRolPorNombre.php';
require_once 'funciones/validaciones.php';
$Mensaje = '';
$Estilo = 'warning';

if (!empty($_POST['BotonModificar'])) {
    // Estoy en condiciones de poder validar los datos
    $Mensaje = Validar_Seleccion_Modificar_Roles();
    if (empty($Mensaje)) {
        // Obtener el nombre del rol seleccionado desde el formulario
        $nombreRolSeleccionado = $_POST['roles'];

        // Buscar el ID del rol seleccionado por su nombre en la base de datos
        $rolSeleccionadoID = buscarIdRolPorNombre($MiConexion, $nombreRolSeleccionado);

        // Verificar si se encontró el ID del rol seleccionado
        if (!$rolSeleccionadoID) {
            // Si el rol no se encontró en la base de datos, redirigir a la página principal o mostrar un mensaje de error
            header('Location: index.php');
            exit;
        } else {
            // Redirigir a la página de modificación con el ID del rol seleccionado como parámetro
            header('Location: modificar_rol.php?id=' . $rolSeleccionadoID);
            exit;
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
                            <li class="breadcrumb-item"><a href="#!">Listado de Roles</a></li>
                        </ul>


                    <div class="card-body table-border-style">
                    	<?php require_once 'alertas.inc.php'; ?>
                        	<form role="form" method="post">
						        <div class="row">
						            <table class="table">
						                <tbody>
						                    <div class="col-md-6">
						                        <div class="form-group">
						                            <label for="exampleFormControlSelect1">Seleccione un rol</label>
						                            <select class="form-control" name="roles" id="roles">
						                                <?php require_once 'seleccionar_roles.php'; ?> 
						                            </select>
						                        </div>
						                    </div>                                
						                </tbody>
						            </table>
						            <div class="col-md-12">
						                <button class="btn  btn-primary" type="submit" value="Modificar" name="BotonModificar">Modificar</button>
						                <a class="btn btn-light" href="index.php" role="button">Volver a Home</a>
						            </div>
						        </div>
						    </form>
                        </div>
                </div>
        </div>

                </div>


       

</section>
<?php require_once 'footer.inc.php'; ?>
