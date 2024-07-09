<?php 
session_start();

if (empty($_SESSION['Usuario_Nombre']) || $_SESSION['Usuario_Rol'] !== "admin") {
    header('Location: cerrarsesion.php');
    exit;
}

require_once 'funciones/conexion.php';
$MiConexion=ConexionBD(); 

require_once 'funciones/select_bebidas.php';
$ListadoBebidas = Listar_Bebidas($MiConexion);
$CantidadBebidas = count($ListadoBebidas);

require_once 'funciones/validaciones.php';
require_once 'funciones/restarBebidas.php';
require_once 'funciones/buscarRecepcionPorId.php';
require_once 'funciones/buscarBebidasPredeterminadas.php';

$Mensaje='';
$Estilo='warning';
if (!empty($_POST['BotonRegistrar'])) {
    // Estoy en condiciones de poder validar los datos
    $Mensaje = Validar_Datos_Restar_Bebidas();
    if (empty($Mensaje)) {

        $detalleRestarBebida = $_POST['detalleRestarBebida'];
        
        if (restarBebidas($MiConexion, $detalleRestarBebida, $ListadoBebidas)) {
            $Mensaje = 'Bebidas restadas de stock.';
            $Estilo = 'success';
        } else {
            $Mensaje = 'Error al restar las bebidas.';
            $Estilo = 'danger';
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
                            <li class="breadcrumb-item">Restar bebidas</li>
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
                        <h5>Restar bebidas</h5>
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
                                        </br></br>
                                        <h3>| Mercadería</h3><span> Elige la cantidad de bebidas de cada para ser restadas del stock (*):</span><hr>
                                    </div>

                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <?php require_once 'vercolumnas.bebidasRegistroRecepcion.inc.php'; ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $idRecepcionModificar = null;
                                            if (isset($_GET['id'])) {
                                                // Obtener el ID de la recepción seleccionada desde la URL
                                                $idRecepcionModificar = $_GET['id'];
                                            }

                                            if ($idRecepcionModificar) {
                                                // Cargar los datos de la recepción seleccionada desde la base de datos
                                                $recepcionAModificar = ObtenerRecepcionPorId($MiConexion, $idRecepcionModificar);

                                                $idCompra = $recepcionAModificar['IDCOMPRA'];
                                                foreach ($ListadoBebidas as $bebida) {
                                                    $cantidadPredeterminada = ObtenerCantidadPredeterminadaParaModificarRecepcionCompra($MiConexion, $bebida['IDBEBIDA'], $idCompra);

                                                    // Muestra los datos en la tabla
                                                    echo '<tr>';
                                                    echo '<td>' . $bebida['IDBEBIDA'] . '</td>';
                                                    echo '<td>' . $bebida['BEBIDA'] . '</td>';
                                                    echo '<td>' . $bebida['MARCA'] . '</td>';
                                                    echo '<td>' . $bebida['VOLUMEN'] . '</td>';
                                                    echo '<td>' . '<input type="text" name="cantidad_' . $bebida['IDBEBIDA'] . '" value="' . $cantidadPredeterminada . '">' . '</td>';
                                                    echo '</tr>';
                                                }
                                            }
                                            else {
                                                foreach ($ListadoBebidas as $bebida) {
                                                    // Muestra los datos en la tabla
                                                    echo '<tr>';
                                                    echo '<td>' . $bebida['IDBEBIDA'] . '</td>';
                                                    echo '<td>' . $bebida['BEBIDA'] . '</td>';
                                                    echo '<td>' . $bebida['MARCA'] . '</td>';
                                                    echo '<td>' . $bebida['VOLUMEN'] . '</td>';
                                                    echo '<td>' . '<input type="text" name="cantidad_' . $bebida['IDBEBIDA'] . '" >' . '</td>';
                                                    echo '</tr>';
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>

                                    <div class="mb-3">
                                        </br>
                                        <label for="detalleRestarBebida" class="form-label">Detalle de la operación (*)</label>
                                        <textarea class="form-control" id="detalleRestarBebida" name="detalleRestarBebida" rows="4"></textarea>
                                        </br>
                                    </div>


                                </div>
                                
                                <div class="col-md-12">
                                    <button class="btn  btn-primary" type="submit" value="Guardar cambios" name="BotonRegistrar"onclick="return confirm('¿Estás seguro de que deseas restar estas bebidas del stock?')">
                                    Confirmar</button> 
                                    <input class="btn btn-secondary" type="reset" value="Limpiar datos o volver a default" name="BotonLimpiar">
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