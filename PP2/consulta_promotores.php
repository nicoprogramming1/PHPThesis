<?php 
session_start();

if (empty($_SESSION['Usuario_Nombre'])) {
    header('Location: cerrarsesion.php');
    exit;
}

require_once 'funciones/conexion.php';
$MiConexion=ConexionBD(); 

require_once 'funciones/buscarEventoPorId.php';
require_once 'funciones/consulta_eventos_promotores.php';
require_once 'funciones/select_promotoresList.php';
require_once 'funciones/select_eventos.php';

$ListadoEventos = Listar_Eventos($MiConexion);
$CantidadEventos= count($ListadoEventos);


require_once 'funciones/validaciones.php';
$Mensaje='';
$Estilo='warning';
if (!empty($_POST['BotonConsultar'])) {
    //estoy en condiciones de poder validar los datos
    $Mensaje=Validar_Seleccion_Consultas_Promotores();
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
                            <li class="breadcrumb-item"><a href="#!">Consultas de promotores</a></li>
                        </ul>


                    <div class="card-body table-border-style">
                    	<?php require_once 'alertas.inc.php'; ?>
                        <form role="form" method="post">
	                        <div class="row">
	                            <div class="form-group">
                                    <label for="promotores" class="form-label">Promotores (*)</label>
                                    <select class="form-control" name="promotores" id="promotores">
                                        <option value="">Seleccionar Promotor</option>
                                        <?php
                                        $promotoresList = ObtenerListaPromotores($MiConexion);
                                        foreach ($promotoresList as $promotor) {
                                            echo '<option value="' . $promotor['idPromotores'] . '">' . $promotor['nombre'] . ' ' . $promotor['apellido'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
	                            <div class="form-group col-md-4">
	                                <button type="submit" class="btn btn-primary" name="BotonConsultar">Consultar</button>
	                            </div>
	                        </div>
	                        <table class="table">
	                            <thead>
	                                <tr>
	                                    <?php require_once 'vercolumnas.eventos.consultas.inc.php'; ?>
	                                </tr>
	                            </thead>
	                            <tbody>
									<?php
                                    $totalAsistentes = 0; // Variable para almacenar el total de asistentes

                                    if (isset($_POST['promotores'])) {
                                        $selectedPromotor = $_POST['promotores'];

                                        if (!empty($selectedPromotor)) {
                                            // Mostrar eventos con la cantidad de asistentes referidos por el promotor y que estén dentro del rango de fechas (si se seleccionaron fechas)
                                            $query = "SELECT e.idEvento, e.detalleEvento, e.fechaEvento, COUNT(ae.asistente) AS countAsistentes
                                                      FROM asistentes_evento AS ae
                                                      INNER JOIN evento AS e ON ae.idevento = e.idEvento
                                                      WHERE ae.idPromotorReferido = ?";

                                            // Si se seleccionaron fechas, agregar el filtro de fechas a la consulta SQL
                                            if (!empty($_POST['fechaInicio']) && !empty($_POST['fechaFin'])) {
                                                $fechaInicio = $_POST['fechaInicio'];
                                                $fechaFin = $_POST['fechaFin'];

                                                // Validar las fechas (asegurarse de que la fecha de inicio sea menor o igual a la fecha de fin)
                                                if ($fechaInicio > $fechaFin) {
                                                    echo '<div class="alert alert-danger">La fecha de inicio debe ser menor o igual a la fecha de fin.</div>';
                                                    exit; // Detener la ejecución si las fechas no son válidas
                                                }

                                                // Agregar el filtro de fechas a la consulta SQL
                                                $query .= " AND e.fechaEvento BETWEEN ? AND ?";
                                            }

                                            // Continuar con la consulta SQL y el código posterior
                                            $query .= " GROUP BY e.idEvento, e.detalleEvento, e.fechaEvento
                                                        ORDER BY countAsistentes DESC";
                                            $stmt = $MiConexion->prepare($query);

                                            // Si se seleccionaron fechas, bindear los parámetros de fecha
                                            if (!empty($_POST['fechaInicio']) && !empty($_POST['fechaFin'])) {
                                                $stmt->bind_param('iss', $selectedPromotor, $fechaInicio, $fechaFin);
                                            } else {
                                                $stmt->bind_param('i', $selectedPromotor);
                                            }

                                            $stmt->execute();
                                            $result = $stmt->get_result();

                                            if ($result->num_rows > 0) {
                                                $contador = 1;
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    echo '<tr>';
                                                    echo '<td>' . $contador . '</td>';
                                                    echo '<td>' . $row['idEvento'] . '</td>';
                                                    echo '<td>' . $row['detalleEvento'] . '</td>';
                                                    // Formatear la fechaEvento a dd/mm/aaaa antes de imprimir en la tabla
											        $fechaEventoFormateada = date('d/m/Y', strtotime($row['fechaEvento']));
											        echo '<td>' . $fechaEventoFormateada . '</td>';
                                                    echo '<td>' . $row['countAsistentes'] . '</td>';
                                                    echo '</tr>';
                                                    $contador++;

                                                    $totalAsistentes += $row['countAsistentes']; // Sumar el valor de asistentes al total
                                                }
                                            } else {
                                                echo '<tr>';
                                                echo '<td colspan="5">No hay eventos para el promotor seleccionado.</td>';
                                                echo '</tr>';
                                            }
                                        } else {
                                            echo '<tr>';
                                            echo '<td colspan="5">Selecciona un promotor para ver sus eventos y asistentes.</td>';
                                            echo '</tr>';
                                        }
                                    } else {
                                        echo '<tr>';
                                        // texto por defecto
                                        echo '</tr>';
                                    }
                                    ?>
	                            </tbody>
	                        </table>
	                        <!-- Mostrar el valor total de asistentes -->
							<div class="total-asistentes">
							    <strong>Total asistentes:</strong> <?php echo $totalAsistentes; ?>
							</div>
							<tr>
						        <?php require_once 'boton.imprimir.inc.php'; ?>
						    </tr>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php require_once 'footer.inc.php'; ?>
<?php require_once 'funciones/script.imprimir.inc.php'; ?>