<?php 
session_start();

if (empty($_SESSION['Usuario_Nombre'])) {
    header('Location: cerrarsesion.php');
    exit;
}

require_once 'funciones/conexion.php';
$MiConexion=ConexionBD(); 

require_once 'funciones/buscarReclamoPorId.php';

require_once 'funciones/select_reclamos.php';
$ListadoReclamos = Listar_Reclamos($MiConexion);
$CantidadReclamos = count($ListadoReclamos);

require_once 'funciones/validaciones.php';
$Mensaje='';
$Estilo='warning';

if (!empty($_POST['BotonConsultar'])) {
    // Estoy en condiciones de poder validar los datos
    $Mensaje = Validar_Seleccion_Consultas_Reclamos();
    
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
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item"><a href="#!">Consultas de reclamos</a></li>
                        </ul>


                    <div class="card-body table-border-style">
                    	<?php require_once 'alertas.inc.php'; ?>
                        <form role="form" method="post">
	                        <div class="row">
	                            <div class="form-group col-md-4">
	                                <label for="reclamos" class="form-label">Reclamos</label>
	                                <select class="form-control" name="reclamos" id="reclamos">
										<option value="">Seleccionar reclamo</option>
										<option value="todos">Todos los reclamos</option>
										<?php
								        foreach ($ListadoReclamos as $reclamo) {
								            echo '<option value="' . $reclamo['IDRECLAMO'] . '">Id: ' . $reclamo['IDRECLAMO'] . ' | Fecha: ' . $reclamo['FECHARECLAMO'] . '</option>';
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
	                                    <?php require_once 'vercolumnas.reclamosConsulta.inc.php'; ?>
	                                </tr>
	                            </thead>
	                            <tbody>
	                                <?php
	                                if (!empty($_POST['BotonConsultar'])) {
									    // Estoy en condiciones de poder validar los datos
									    $selectedReclamo = $_POST['reclamos'];
									    $contador = 1;
									    
									    if ($selectedReclamo === "todos") {
									        // Mostrar todos los reclamos
									        foreach ($ListadoReclamos as $reclamo) {
									            // Muestra los datos en la tabla
									            echo '<tr>';
									            echo '<td>' . $contador . '</td>';
									            echo '<td>' . $reclamo['IDRECLAMO'] . '</td>';
									            echo '<td>' . $reclamo['FECHARECLAMO'] . '</td>';
									            echo '<td>' . $reclamo['FECHACAMBIOESTADORECLAMO'] . '</td>';
									            echo '<td>' . $reclamo['ESTADORECLAMO'] . '</td>';
									            echo '<td>' . $reclamo['DETALLERECLAMO'] . '</td>';
									            echo '<td>' . $reclamo['NOMBREPROVEEDOR'] . '</td>';
									            echo '<td>' . $reclamo['IDRECEPCIONCOMPRA'] . '</td>';

									            echo '</tr>';
									            $contador++;
									        }
									    } else if (!empty($selectedReclamo)) {
									        // Mostrar detalles del reclamo seleccionado
									        $detalleReclamo = ObtenerReclamoPorId($MiConexion, $selectedReclamo);
									        
									        if ($detalleReclamo) {
									            echo '<tr>';
									            echo '<td>' . $contador . '</td>';
									            echo '<td>' . $reclamo['IDRECLAMO'] . '</td>';
									            echo '<td>' . $reclamo['FECHARECLAMO'] . '</td>';
									            echo '<td>' . $reclamo['FECHACAMBIOESTADORECLAMO'] . '</td>';
									            echo '<td>' . $reclamo['ESTADORECLAMO'] . '</td>';
									            echo '<td>' . $reclamo['DETALLERECLAMO'] . '</td>';
									            echo '<td>' . $reclamo['NOMBREPROVEEDOR'] . '</td>';
									            echo '<td>' . $reclamo['IDRECEPCIONCOMPRA'] . '</td>';
									            echo '</tr>';
									            $contador++;
									        } else {
									            // Muestra un mensaje si no hay datos para el reclamo seleccionado
									            echo '<tr>';
									            echo '<td colspan="7">No hay datos para este reclamo.</td>';
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