<?php 
session_start();

if (empty($_SESSION['Usuario_Nombre'])) {
    header('Location: cerrarsesion.php');
    exit;
}

require_once 'funciones/conexion.php';
$MiConexion=ConexionBD(); 

require_once 'funciones/buscarProveedorPorId.php';

require_once 'funciones/select_proveedores.php';
$ListadoProveedores = Listar_Proveedores($MiConexion);
$CantidadProveedores= count($ListadoProveedores);

require_once 'funciones/validaciones.php';
$Mensaje='';
$Estilo='warning';

if (!empty($_POST['BotonConsultar'])) {
    // Estoy en condiciones de poder validar los datos
    $Mensaje = Validar_Seleccion_Consultas_Proveedores();
    
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
                            <h5 class="m-b-10">Administración de Proveedores</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item"><a href="#!">Consultas de proveedores</a></li>
                        </ul>


                    <div class="card-body table-border-style">
                    	<?php require_once 'alertas.inc.php'; ?>
                        <form role="form" method="post">
	                        <div class="row">
	                            <div class="form-group col-md-4">
	                                <label for="listaProveedores" class="form-label">Proveedores</label>
	                                <select class="form-control" name="listaProveedores" id="listaProveedores">
										<option value="">Seleccionar proveedor</option>
										<option value="todos">Todos los proveedores</option>
										<?php
								        foreach ($ListadoProveedores as $proveedores) {
								            echo '<option value="' . $proveedores['IDPROVEEDOR'] . '">Id: ' . $proveedores['IDPROVEEDOR'] . ' | ' . $proveedores['NOMBREPROVEEDOR'] . ' | ' . $proveedores['CUIL'] . '</option>';
								        }
										?>
									</select>
	                            </div>
	                            <div class="form-group col-md-4">
	                                <button type="submit" class="btn btn-primary" name="BotonConsultar">Consultar</button>
	                                <input type="hidden" name="BotonConsultar" value="1">
	                            </div>
	                        </div>
	                        <table class="table">
	                            <thead>
	                                <tr>
	                                    <?php require_once 'vercolumnas.proveedoresConsulta.inc.php'; ?>
	                                </tr>
	                            </thead>
	                            <tbody>
	                                <?php
	                                if (!empty($_POST['BotonConsultar'])) {
									    // Estoy en condiciones de poder validar los datos
									    $selectedProveedor = $_POST['listaProveedores'];
									    $contador = 1;
									    
									    if ($selectedProveedor === "todos") {
									        // Mostrar todos los proveedores
									        foreach ($ListadoProveedores as $proveedor) {
									            // Muestra los datos en la tabla
									            echo '<tr>';
									            echo '<td>' . $contador . '</td>';
									            echo '<td>' . $proveedor['IDPROVEEDOR'] . '</td>';
									            echo '<td>' . $proveedor['NOMBREPROVEEDOR'] . '</td>';
									            echo '<td>' . $proveedor['CUIL'] . '</td>';
									            echo '<td>' . $proveedor['DOMICILIO'] . '</td>';
									            echo '<td>' . $proveedor['TELEFONO'] . '</td>';
									            echo '<td>' . $proveedor['EMAIL'] . '</td>';
									            echo '</tr>';
									            $contador++;
									        }
									    } else if (!empty($selectedProveedor)) {
									        // Mostrar detalles del proveedor seleccionado
									        $detalleProveedor = ObtenerProveedorPorId($MiConexion, $selectedProveedor);
									        
									        if ($detalleProveedor) {
									            echo '<tr>';
									            echo '<td>' . $contador . '</td>';
									            echo '<td>' . $detalleProveedor['IDPROVEEDOR'] . '</td>';
									            echo '<td>' . $detalleProveedor['NOMBREPROVEEDOR'] . '</td>';
									            echo '<td>' . $detalleProveedor['CUIL'] . '</td>';
									            echo '<td>' . $detalleProveedor['DOMICILIO'] . '</td>';
									            echo '<td>' . $detalleProveedor['TELEFONO'] . '</td>';
									            echo '<td>' . $detalleProveedor['EMAIL'] . '</td>';
									            echo '</tr>';
									            $contador++;
									        } else {
									            // Muestra un mensaje si no hay datos para el proveedor seleccionado
									            echo '<tr>';
									            echo '<td colspan="7">No hay datos para este proveedor.</td>';
									            echo '</tr>';
									        }
									    }
									}
	                                ?>
	                            </tbody>
	                            <?php require_once 'boton.imprimir.inc.php'; ?>
	                        </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php require_once 'footer.inc.php'; ?>
<?php require_once 'funciones/script.imprimir.inc.php'; ?>