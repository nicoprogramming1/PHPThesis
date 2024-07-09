<?php 
session_start();

if (empty($_SESSION['Usuario_Nombre']) || $_SESSION['Usuario_Rol'] !== "admin") {
    header('Location: cerrarsesion.php');
    exit;
}

require_once 'funciones/conexion.php';
$MiConexion=ConexionBD(); 

require_once 'funciones/select_comprasList.php';
$ListadoCompras = ObtenerListaCompras($MiConexion);

require_once 'funciones/select_estadosRecepcionList.php';
$ListadoEstados = ObtenerListaEstadosRecepcion($MiConexion);

require_once 'funciones/select_bebidas.php';
$ListadoBebidas = Listar_Bebidas($MiConexion);
$CantidadBebidas = count($ListadoBebidas);

require_once 'funciones/validaciones.php';
require_once 'funciones/insertar_recepciones.php';

$Mensaje='';
$Estilo='warning';
if (!empty($_POST['BotonRegistrar'])) {
    // Estoy en condiciones de poder validar los datos
    $Mensaje = Validar_Datos_Registrar_Recepcion();
    if (empty($Mensaje)) {
        // Insertar en la base de datos
        $resultado = InsertarRecepcionEnBaseDeDatos($MiConexion, $ListadoBebidas);
        if ($resultado) {
            $Mensaje = "Recepción registrada con éxito.";
            $Estilo = "success";
        } else {
            $Mensaje = "Error al registrar la recepción en la base de datos.";
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
                            <li class="breadcrumb-item">Registrar recepción de compra</li>
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
                        <h5>Registrar recepción de compra</h5>
                        <hr>
                        <?php require_once 'alertas.inc.php'; ?>

                        <div class="alert alert-info" role="alert">
                        <i data-feather="info"></i> 
							Los campos con * son obligatorios. 
						</div>

                        <form role="form" method="post" enctype="multipart/form-data">
                            <div class="row">

                                <div class="col-md-6">

                                    <div class="mb-3">
                                        <h3>| Remito</h3><span> Carga la información asociada al remito</span><hr>
                                    </div>

                                    <div class="mb-3">
                                        <label for="nroRemito" class="form-label">Número de remito (*)</label>
                                        <input type="text" class="form-control" id="nroRemito" name="nroRemito" placeholder="Ingrese el número del remito">
                                    </div>

                                    <div class="mb-3">
                                        <label for="fechaRemito" class="form-label">Fecha de remito (*)</label>
                                        <input type="text" class="form-control" id="fechaRemito" name="fechaRemito" placeholder="Selecciona la fecha que figura en el remito">
                                    </div>

                                    <div class="mb-3">
                                        <label for="remito" class="form-label">Cargar remito (*)</label>
                                        <input type="file" class="form-control" id="remito" name="remito">
                                    </div>

                                    <div class="mb-3">
                                        <label for="detalleRemito" class="form-label">Detalle del remito</label>
                                        <textarea class="form-control" id="detalleRemito" name="detalleRemito" rows="4"></textarea>
                                    </div>

                                    <div class="mb-3">
                                        </br></br>
                                        <h3>| Recepción</h3><span> Carga los detalles de la recepción de mercadería</span><hr>
                                    </div>

                                    <div class="mb-3">
                                        <label for="fechaRecepcion" class="form-label">Fecha de recepción (*)</label>
                                        <input type="text" class="form-control" id="fechaRecepcion" name="fechaRecepcion" placeholder="Selecciona la fecha de recepción">
                                    </div>

                                    <div class="mb-3">
                                        <label for="detalleRecepcion" class="form-label">Detalle recepción de compra</label>
                                        <textarea class="form-control" id="detalleRecepcion" name="detalleRecepcion" rows="4"></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="estadoRecepcion" class="form-label">Estado de la recepción (*)</label>
                                        <select class="form-control" name="estadoRecepcion" id="estadoRecepcion">
                                            <option value="">Seleccionar estado</option>
                                            <?php
                                            foreach ($ListadoEstados as $estado) {
                                                echo '<option value="' . $estado['IDESTADORECEPCION'] . '">' . ' Estado: ' . $estado['ESTADORECEPCION'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="compra" class="form-label">Compra por la cual recepcionamos (*)</label>
                                        <select class="form-control" name="compra" id="compra">
                                            <option value="">Seleccionar compra</option>
                                            <?php
                                            foreach ($ListadoCompras as $compra) {
                                                echo '<option value="' . $compra['IDCOMPRA'] . '">' . ' ID: ' . $compra['IDCOMPRA'] . ' | Fecha de compra: ' . $compra['FECHACOMPRA'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        </br></br>
                                        <h3>| Mercadería</h3><span> Carga la mercadería ingresante, es obligatorio cargar al menos una bebida</span><hr>
                                    </div>

                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <?php require_once 'vercolumnas.bebidasRegistroRecepcion.inc.php'; ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            
                                            foreach ($ListadoBebidas as $bebida) {
                                                // Muestra los datos en la tabla
                                                echo '<tr>';
                                                echo '<td>' . $bebida['IDBEBIDA'] . '</td>';
                                                echo '<td>' . $bebida['BEBIDA'] . '</td>';
                                                echo '<td>' . $bebida['MARCA'] . '</td>';
                                                echo '<td>' . $bebida['VOLUMEN'] . '</td>';
                                                echo '<td>' . '<input type="text" name="cantidad_' . $bebida['IDBEBIDA'] . '">' . '</td>';
                                                echo '</tr>';
                                            }
                                            ?>
                                        </tbody>
                                    </table>


                                </div>
                                
                                <div class="col-md-12">
                                    <button class="btn  btn-primary" type="submit" value="Registrar" name="BotonRegistrar">
                                    Registrar</button> 
                                    <input class="btn btn-secondary" type="reset" value="Limpiar datos" name="BotonLimpiar">
                                    <a class="btn btn-light" href="index.php" role="button">Volver a Home</a>
                                </div>
                                
                            </div>
                        </form>

                        <script>
                            $('#fechaRecepcion, #fechaRemito').datetimepicker({
                                format: 'DD/MM/YY', // Formato latino "dd/mm/yy"
                                icons: {
                                    time: "far fa-clock",
                                    date: "far fa-calendar",
                                    up: "fas fa-chevron-up",
                                    down: "fas fa-chevron-down",
                                    previous: "fas fa-chevron-left",
                                    next: "fas fa-chevron-right",
                                    today: "far fa-calendar-check",
                                    clear: "far fa-trash-alt",
                                    close: "far fa-times-circle"
                                }
                            });
                        </script>
                    </div>
                </div>
            </div>
            <!-- [ form-element ] end -->
        </div>
        <!-- [ Main Content ] end -->

    </div>
</section>

<?php require_once 'footer.inc.php'; ?>