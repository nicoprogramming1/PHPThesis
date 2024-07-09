<?php 
session_start();

if (empty($_SESSION['Usuario_Nombre'])) {
    header('Location: cerrarsesion.php');
    exit;
}

require_once 'funciones/conexion.php';
$MiConexion=ConexionBD(); 

require_once 'funciones/buscarEventoPorId.php';
require_once 'funciones/buscarAsistentePorEvento.php';
require_once 'funciones/consulta_eventos_asistentes.php';
require_once 'funciones/select_eventos.php';
$ListadoEventos = Listar_Eventos($MiConexion);
$CantidadEventos= count($ListadoEventos);


require_once 'funciones/validaciones.php';
$Mensaje='';
$Estilo='warning';
if (!empty($_POST['BotonConsultar'])) {
    //estoy en condiciones de poder validar los datos
    $Mensaje=Validar_Seleccion_Planilla();
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
                            <h5 class="m-b-10">Administración de asistentes</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item"><a href="#!">Consultas de eventos</a></li>
                        </ul>


                    <div class="card-body table-border-style">
                    	<?php require_once 'alertas.inc.php'; ?>
                        <form role="form" method="post">
	                        <div class="row">
	                            <div class="form-group col-md-4">
	                                <label for="eventos" class="form-label">Eventos</label>
	                                <select class="form-control" name="eventos" id="Eventos">
	                                    <option value="">Seleccionar evento</option>
	                                    <?php
	                                    foreach ($ListadoEventos as $evento) {
	                                        echo '<option value="' . $evento['IDEVENTO'] . '">' . $evento['DETALLEEVENTO'] . ' | ' . $evento['FECHAEVENTO'] . '</option>';
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
	                                    <?php require_once 'vercolumnas.planillas.inc.php'; ?>
	                                </tr>
	                            </thead>
	                            <tbody>
								<?php
								$asistentesEvento = array(); // Declarar e inicializar la variable $asistentesEvento como un arreglo vacío
								if (!empty($_POST['BotonConsultar'])) {
								    $selectedEvento = $_POST['eventos'];

								    if (!empty($selectedEvento)) {
								        $asistentesEvento = ObtenerAsistentesPorEvento($MiConexion, $selectedEvento);

								        if (!empty($asistentesEvento)) {
								            $contador = 1;
								            foreach ($asistentesEvento as $asistente) {
								                echo '<tr>';
								                echo '<td>' . $contador . '</td>';
								                echo '<td>' . $asistente['nombre'] . '</td>';
											    echo '<td>' . $asistente['dni'] . '</td>';
								                echo '</tr>';
								                $contador++;
								            }
								        } else {
								            echo '<tr>';
								            echo '<td colspan="3">No hay asistentes para este evento.</td>';
								            echo '</tr>';
								        }
								    } else {
								        echo '<tr>';
								        // Coloca aquí los datos por defecto o vacíos que quieras mostrar cuando no hay evento seleccionado
								        echo '</tr>';
								    }
								}
								?>
								</tbody>
								<tfoot>
								    <tr>
								        <td colspan="3" style="text-align: right;">Total de asistentes = <?php echo count($asistentesEvento); ?></td>
								    </tr>
								    <?php require_once 'boton.imprimir.inc.php'; ?>
								</tfoot>
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