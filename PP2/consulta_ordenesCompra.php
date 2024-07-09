<?php 
session_start();

if (empty($_SESSION['Usuario_Nombre'])) {
    header('Location: cerrarsesion.php');
    exit;
}

require_once 'funciones/conexion.php';
$MiConexion=ConexionBD(); 

require_once 'funciones/buscarOrdenCompraPorIdParaConsulta.php';
require_once 'funciones/select_ordenCompra.php';
require_once 'funciones/select_ordenCompraParaConsulta.php';
$ListadoOrdenCompra = Listar_ordenCompra($MiConexion);
$CantidadOrdenCompra = count($ListadoOrdenCompra);

require_once 'funciones/validaciones.php';
$Mensaje='';
$Estilo='warning';

if (!empty($_POST['BotonConsultar'])) {
    // Estoy en condiciones de poder validar los datos
    $Mensaje = Validar_Seleccion_Consultas_OrdenesCompra();
    
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
                            <h5 class="m-b-10">Administración de Compras</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item"><a href="#!">Consultas de Ordenes de Compra</a></li>
                        </ul>


                    <div class="card-body table-border-style">
                    	<?php require_once 'alertas.inc.php'; ?>
                        <form role="form" method="post">
	                        <div class="row">
	                            <div class="form-group col-md-4">
	                                <label for="ordenes" class="form-label">Ordenes de Compra</label>
	                                <select class="form-control" name="ordenes" id="ordenes">
										<option value="">Seleccionar Orden de Compra</option>
										<option value="todos">Todas las ordenes de compra</option>
										<?php
								        foreach ($ListadoOrdenCompra as $ordenCompra) {
								            echo '<option value="' . $ordenCompra['IDORDENCOMPRA'] . '">Id: ' . $ordenCompra['IDORDENCOMPRA'] . ' | ' . $ordenCompra['FECHAORDENCOMPRA'] . ' | ' . $ordenCompra['PROVEEDORORDENCOMPRA'] . '</option>';
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
	                                    <?php require_once 'vercolumnas.ordenCompra.consultas.inc.php'; ?>
	                                </tr>
	                            </thead>
	                            <tbody>
	                                <?php
	                                if (!empty($_POST['BotonConsultar'])) {
									    // Estoy en condiciones de poder validar los datos
									    $selectedOrden = $_POST['ordenes'];
		                                $contador = 1;
		                                if ($selectedOrden === "todos") {
										    // Mostrar todas las ordenes ordenadas por fecha de creación
										    $ListadoOrdenes = Listar_ordenCompraParaConsulta($MiConexion);
										    if (!empty($ListadoOrdenes)) {
										        foreach ($ListadoOrdenes as $ordenes) {
										            echo '<tr>';
										            echo '<td>' . $contador . '</td>';
										            echo '<td>' . $ordenes['IDORDENCOMPRA'] . '</td>';
										            echo '<td>' . $ordenes['FECHAORDENCOMPRA'] . '</td>';
										            echo '<td>' . $ordenes['ESTADOORDENCOMPRA'] . '</td>';
										            echo '<td>' . $ordenes['PROVEEDORORDENCOMPRA'] . '</td>';
										            echo '<td>' . $ordenes['FECHAMODIFICACION'] . '</td>';
										            echo '<td>' . $ordenes['FECHAENVIO'] . '</td>';
										            echo '</tr>';
										            $contador++;
										        }
										    } else {
										        echo '<tr>';
										        echo '<td colspan="5">No hay ordenes de compra disponibles.</td>';
										        echo '</tr>';
										    }
										} else if (!empty($selectedOrden)) {
										    // Mostrar detalles de la orden de compra seleccionada
										    $contenidoOrdenCompra = ObtenerOrdenCompraPorIDParaConsulta($MiConexion, $selectedOrden);
										    if ($contenidoOrdenCompra) {
										        echo '<tr>';
										        echo '<td>' . $contador . '</td>';
										        echo '<td>' . $contenidoOrdenCompra[0]['IDORDENCOMPRA'] . '</td>';
										        echo '<td>' . $contenidoOrdenCompra[0]['FECHAORDENCOMPRA'] . '</td>';
										        echo '<td>' . $contenidoOrdenCompra[0]['ESTADOORDENCOMPRA'] . '</td>';
										        echo '<td>' . $contenidoOrdenCompra[0]['PROVEEDORORDENCOMPRA'] . '</td>';
										        echo '<td>' . $contenidoOrdenCompra[0]['FECHAMODIFICACION'] . '</td>';
										        echo '<td>' . $contenidoOrdenCompra[0]['FECHAENVIO'] . '</td>';
										        $contador++;
										        echo '</tr>';
										    } else {
										        echo '<tr>';
										        echo '<td colspan="5">No hay datos para esta orden de compra.</td>';
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