<?php 
session_start();

if (empty($_SESSION['Usuario_Nombre'])) {
    header('Location: cerrarsesion.php');
    exit;
}

require_once 'funciones/conexion.php';
$MiConexion=ConexionBD(); 

require_once 'funciones/buscarBebidaPorVolumen.php';

require_once 'funciones/select_bebidas.php';
$ListadoBebidas = Listar_Bebidas($MiConexion);
$CantidadBebidas = count($ListadoBebidas);

require_once 'funciones/buscarMarcaPorId.php';

require_once 'funciones/select_volumenes.php';
$ListadoVolumenes = Listar_Volumenes($MiConexion);
$CantidadVolumenes = count($ListadoVolumenes);

require_once 'funciones/validaciones.php';
$Mensaje='';
$Estilo='warning';

if (!empty($_POST['BotonConsultar'])) {
    // Estoy en condiciones de poder validar los datos
    $Mensaje = Validar_Seleccion_Consultas_Volumen();
    
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
				<a href="index.php" class="b-brand">
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
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item"><a href="#!">Consultas de bebidas por volumen</a></li>
                        </ul>


                    <div class="card-body table-border-style">
                    	<?php require_once 'alertas.inc.php'; ?>
                        <form role="form" method="post">
	                        <div class="row">
	                            <div class="form-group col-md-4">
	                                <label for="volumen" class="form-label">Volumen</label>
	                                <select class="form-control" name="volumen" id="volumen">
										<option value="">Seleccionar volumen</option>
										<option value="todos">Todos los volumenes</option>
										<?php
								        foreach ($ListadoVolumenes as $volumen) {
								            echo '<option value="' . $volumen['IDVOLUMEN'] . '">Id: ' . $volumen['IDVOLUMEN'] . ' | ' . $volumen['VOLUMEN'] . '</option>';
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
	                                    <?php require_once 'vercolumnas.bebidasConsultaPorVolumen.inc.php'; ?>
	                                </tr>
	                            </thead>
	                            <tbody>
	                                <?php
	                                if (!empty($_POST['BotonConsultar'])) {
									    // Estoy en condiciones de poder validar los datos
									    $selectedVolumen = $_POST['volumen'];
									    $contador = 1;
									    
									    if ($selectedVolumen === "todos") {
									        // Mostrar todas las bebidas
									        foreach ($ListadoBebidas as $bebida) {
									            // Muestra los datos en la tabla
									            echo '<tr>';
									            echo '<td>' . $contador . '</td>';
									            echo '<td>' . $bebida['IDBEBIDA'] . '</td>';
									            echo '<td>' . $bebida['BEBIDA'] . '</td>';
									            echo '<td>' . $bebida['MARCA'] . '</td>';
									            echo '</tr>';
									            $contador++;
									        }
									    } else if (!empty($selectedVolumen)) {
									        // Mostrar detalles del proveedor seleccionado
									        $detalleBebida = ObtenerBebidaPorVolumen($MiConexion, $selectedVolumen);
									        
									        if ($detalleBebida) {
									            echo '<tr>';
									            echo '<td>' . $contador . '</td>';
									            echo '<td>' . $detalleBebida['IDBEBIDA'] . '</td>';
									            echo '<td>' . $detalleBebida['BEBIDA'] . '</td>';
									            echo '<td>' . $detalleBebida['MARCA'] . '</td>';
									            echo '</tr>';
									            $contador++;
									        } else {
									            // Muestra un mensaje si no hay datos para la bebida seleccionada
									            echo '<tr>';
									            echo '<td colspan="7">No hay datos para esta bebida.</td>';
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