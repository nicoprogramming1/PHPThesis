<?php 
session_start();

if (empty($_SESSION['Usuario_Nombre'])) {
    header('Location: cerrarsesion.php');
    exit;
}

require_once 'funciones/conexion.php';
$MiConexion=ConexionBD(); 

require_once 'funciones/select_ordenCompra.php';
$ListadoOrdenCompra = Listar_ordenCompra($MiConexion);
$CantidadOrdenCompra = count($ListadoOrdenCompra);

require_once 'funciones/cambiarEstado_ordenCompra.php';

$ordenCompraSeleccionada = []; // Inicializa como un array vacío


require_once 'funciones/validaciones.php';
$Mensaje='';
$Estilo='warning';
if (!empty($_POST['BotonModificar'])) {
    //estoy en condiciones de poder validar los datos
    $Mensaje=Validar_Seleccion_Modificar_OrdenCompra();
    if (empty($Mensaje)) {
        // Obtener el id de la orden de compra seleccionada
        $ordenCompraSeleccionada = $_POST['seleccionar'];

        // Redirigir a la página de modificación con el id seleccionado como parámetro
        header('Location: modificar_ordenCompra.php?id=' . implode(',', $ordenCompraSeleccionada));
        exit;
    }
    else {
		$Estilo='danger';
    }
}

if (!empty($_POST['BotonEnviarOrden'])) {
    $Mensaje = Validar_Seleccion_Modificar_OrdenCompra();
    if (empty($Mensaje)) {
        // Obtener el id de la orden de compra seleccionada
        $ordenCompraSeleccionada = $_POST['seleccionar'];

        // Llama a la función para cambiar el estado de la orden de compra
        if (CambiarEstadoOrdenCompra($MiConexion, $ordenCompraSeleccionada, 1)) {
            $Mensaje = 'Se ha enviado la orden de compra correctamente.';
            $Estilo = 'success';
        } else {
            $Mensaje = 'Error al enviar la orden de compra.';
            $Estilo = 'danger';
        }
    } else {
        $Estilo = 'danger';
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
                            <h5 class="m-b-10">Administración de Compras</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item"><a href="#!">Listado de Órdenes de Compra</a></li>
                        </ul>

                    <div class="card-body table-border-style">
                    	<?php require_once 'alertas.inc.php'; ?>
                        	<form role="form" method="post">
	                        	<div class="row">
		                            <table class="table">
		                                <thead>
		                                    <tr>
		                                    	<?php require_once 'vercolumnas.ordenesCompra.inc.php'; ?>
		                                    </tr>
		                                </thead>
		                                <tbody>
		                                	    <?php require_once 'listado.ordenesCompra.inc.php'; ?>

		                                </tbody>
		                            </table>

		                            <!-- Campo oculto para almacenar la orden de compra seleccionada ya que sino produce conflicto por arrays (en listado.ordenesCompra.inc.php se trata como name="seleccionar[]) -->
                                    <input type="hidden" name="ordenCompraSeleccionada" value="<?php echo implode(',', $ordenCompraSeleccionada); ?>">

		                            <div class="col-md-12">
	                                    <button class="btn  btn-primary" type="submit" value="Modificar" name="BotonModificar">Modificar</button>
	                                    <a class="btn btn-light" href="index.php" role="button">Volver a Home</a>
	                                    <button class="btn  btn-success" type="submit" value="EnviarOrdenCompra" name="BotonEnviarOrden">Enviar Orden de Compra</button>
                            		</div>
		                        </div>
	                        </form>
                        </div>
                </div>
        </div>
    </div>
</section>
<?php require_once 'footer.inc.php'; ?>

<!-- Script JavaScript para rastrear la selección de checkbox -->
<script>
    var checkboxes = document.querySelectorAll('input[name="seleccionar[]"]');
    checkboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            var selectedValues = [];
            checkboxes.forEach(function(checkbox) {
                if (checkbox.checked) {
                    selectedValues.push(checkbox.value);
                }
            });
            document.querySelector('input[name="ordenCompraSeleccionada"]').value = selectedValues.join(',');
        });
    });
</script>