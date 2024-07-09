<?php 
session_start();

if (empty($_SESSION['Usuario_Nombre']) || $_SESSION['Usuario_Rol'] !== "admin") {
    header('Location: cerrarsesion.php');
    exit;
}

require_once 'funciones/conexion.php';
$MiConexion=ConexionBD(); 

require_once 'funciones/validaciones.php';
require_once 'funciones/insertar_reclamo.php';

require_once 'funciones/select_proveedores.php';
$ListadoProveedores = Listar_Proveedores($MiConexion);

require_once 'funciones/select_recepcionesParaReclamos.php';
$ListadoRecepciones = Listar_Recepciones($MiConexion);

$Mensaje='';
$Estilo='warning';
if (!empty($_POST['BotonRegistrar'])) {
    // Estoy en condiciones de poder validar los datos
    $Mensaje = Validar_Datos_Registrar_Reclamo();
    if (empty($Mensaje)) {
        
        $detalleReclamo = $_POST['detalleReclamo'];
        $idProveedor = $_POST['proveedor'];
        $idRecepcionCompra = $_POST['recepcionCompra'];

        $resultado = InsertarReclamo($MiConexion, $detalleReclamo, $idProveedor, $idRecepcionCompra);
        if ($resultado) {
            $Mensaje = "Reclamo registrado con éxito.";
            $Estilo = "success";
        } else {
            $Mensaje = "Error al registrar el reclamo en la base de datos.";
            $Estilo = "danger";
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
                            <h5 class="m-b-10">Administración de Stock</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                            <li class="breadcrumb-item"><a href="#!">Stock</a></li>
                            <li class="breadcrumb-item">Nuevo reclamo</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->
        <!-- [ Main Content ] start -->
        <div class="row">
            <!-- [ form-element ] start -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h5>Registrar reclamo</h5>
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
                                        <label for="detalleReclamo" class="form-label">Detalle (*)</label>
                                        <textarea class="form-control" id="detalleReclamo" name="detalleReclamo" rows="4"></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="proveedor" class="form-label">Proveedor (*)</label>
                                        <select class="form-control" name="proveedor" id="proveedor">
                                            <option value="">Seleccionar proveedor</option>
                                            <?php
                                            foreach ($ListadoProveedores as $proveedor) {
                                                echo '<option value="' . $proveedor['IDPROVEEDOR'] . '">ID= ' . $proveedor['IDPROVEEDOR'] . ' | ' . $proveedor['NOMBREPROVEEDOR'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>

                                  <div class="form-group">
                                    <label for="recepcionCompra" class="form-label">Recepción de compra (*)</label>
                                    <select class="form-control" name="recepcionCompra" id="recepcionCompra">
                                        <option value="">Seleccionar recepcion de compra</option>
                                        <?php
                                        foreach ($ListadoRecepciones as $recepcion) {
                                            echo '<option value="' . $recepcion['IDRECEPCIONCOMPRA'] . '">ID= ' . $recepcion['IDRECEPCIONCOMPRA'] . ' | ' . $recepcion['FECHARECEPCIONCOMPRA'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>

                                </div>
                                
                                <div class="col-md-12">
                                    <button class="btn  btn-primary" type="submit" value="Registrar" name="BotonRegistrar">
                                    Registrar</button> 
                                    <input class="btn btn-secondary" type="reset" value="Limpiar datos" name="BotonLimpiar">
                                    <a class="btn btn-light" href="index.php" role="button">Volver a Home</a>
                                </div>
                                
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- [ form-element ] end -->
        </div>
        <!-- [ Main Content ] end -->

    </div>
</section>

<?php require_once 'footer.inc.php'; ?>