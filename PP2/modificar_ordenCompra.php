<?php 
session_start();

if (empty($_SESSION['Usuario_Nombre'])) {
    header('Location: cerrarsesion.php');
    exit;
}

require_once 'funciones/conexion.php';
$MiConexion = ConexionBD();

require_once 'funciones/actualizar_ordenCompra.php';
require_once 'funciones/buscarOrdenCompraPorId.php';
require_once 'funciones/validaciones.php';
require_once 'funciones/eliminarOrdenCompra.php';
require_once 'funciones/select_bebidasList.php';
require_once 'funciones/select_proveedoresList.php';
require_once 'funciones/buscarBebidasPredeterminadas.php';

$ListadoBebidas = ObtenerListaBebidas($MiConexion);
$CantidadBebidas = count($ListadoBebidas);

// Obtener el ID de la orden de compra seleccionada desde la URL
if (isset($_GET['id'])) {
    $idOrdenCompraSeleccionada = $_GET['id'];
} else {
    // Si no se proporcionó el ID, redirigir al listado de asistentes
    header('Location: listado_ordenCompra.php');
    exit;
}

// Obtener los datos de la orden de compra seleccionada
$datosOrdenCompra = ObtenerOrdenCompraPorID($MiConexion, $idOrdenCompraSeleccionada);

// Verificar si la orden de compra existe y mostrar mensaje si no se encontró
if (!$datosOrdenCompra) {
    $Mensaje = 'La orden de compra seleccionada no existe.';
    $Estilo = 'danger';
    $datosOrdenCompra = array(); // Inicializar los datos vacíos
}

$Mensaje = '';
$Estilo = 'warning';

if (isset($_POST['BotonGuardar'])) {
    $Mensaje = Validar_Modificar_OrdenCompra();

    if (empty($Mensaje)) {
        // Obtener el nuevo proveedor
        $nuevoProveedor = $_POST['proveedor'];

        // Actualizar el proveedor de la orden de compra
        if (ActualizarProveedorOrdenCompra($MiConexion, $idOrdenCompraSeleccionada, $nuevoProveedor)) {
            $Mensaje = 'Proveedor actualizado correctamente.';

            // Actualizar las cantidades de bebidas
            foreach ($ListadoBebidas as $bebida) {
                $idBebida = $bebida['idBebida'];
                $nombreCampoCantidad = 'cantidadBebida_' . $idBebida;

                if (isset($_POST[$nombreCampoCantidad])) {
                    $nuevaCantidad = (int)$_POST[$nombreCampoCantidad];

                    // Actualizar la cantidad de bebida si es mayor que cero
                    if ($nuevaCantidad > 0) {
                        ActualizarCantidadBebida($MiConexion, $idOrdenCompraSeleccionada, $idBebida, $nuevaCantidad);
                    } else {
                        // Eliminar la entrada en la tabla detalle_ordencompra
                        EliminarDetalleOrdenCompra($MiConexion, $idOrdenCompraSeleccionada, $idBebida);
                    }
                }
            }

            $Estilo = 'success';
        } else {
            $Mensaje = 'Error al actualizar el proveedor.';
            $Estilo = 'danger';
        }
    }
}

if (isset($_POST['BotonEliminar'])) {
    if (EliminarOrdenCompraYDetalles($MiConexion, $idOrdenCompraSeleccionada)) {
        $Mensaje = 'Se ha eliminado correctamente la orden de compra y sus detalles.';
        $Estilo = 'success';
        // Redirigir a la lista de orden de compra después de la eliminación exitosa
        header('Location: listado_ordenCompra.php');
        exit;
    } else {
        $Mensaje = 'Error al eliminar la orden de compra.';
        $Estilo = 'danger';
    }
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
                            <h5 class="m-b-10">Administración de Compras</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item"><a href="#!">Modificar Órden de Compra</a></li>
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
                        
                        <?php require_once 'alertas.inc.php'; ?>
                        
                        <form role="form" method="post">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="proveedor" class="form-label">Proveedor (*)</label>
                                <select class="form-control" name="proveedor" id="proveedor">
                                    <?php
                                    $proveedoresList = ObtenerListaProveedores($MiConexion);
                                    foreach ($proveedoresList as $proveedor) {
                                        $selected = '';
                                        if ($proveedor['idProveedor'] == $datosOrdenCompra['idProveedor']) {
                                            $selected = 'selected'; // Establecer como seleccionado si coincide con el proveedor de la orden
                                        }
                                        echo '<option value="' . $proveedor['idProveedor'] . '" ' . $selected . '>' . $proveedor['nombreProveedor'] . ' (ID: ' . $proveedor['idProveedor'] . ')</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <table class="table">
                                <thead>
                                    <?php require_once 'vercolumnas.ordencompra.inc.php'; ?>
                                </thead>
                                <tbody>
                                    <?php
                                    $contador = 1;
                                    foreach ($ListadoBebidas as $bebida) {
                                        $idBebida = $bebida['idBebida'];
                                        // Obtener el valor predeterminado de cantidad desde la base de datos
                                        $cantidadPredeterminada = ObtenerCantidadPredeterminada($MiConexion, $idBebida, $idOrdenCompraSeleccionada);

                                        echo '<tr>';
                                        echo '<td>' . $contador . '</td>';
                                        echo '<td>' . $bebida['bebida'] . ' - ' . $bebida['marca'] . '</td>';
                                        echo '<td><input type="text" name="cantidadBebida_' . $idBebida . '" value="' . $cantidadPredeterminada . '"></td>';
                                        echo '</tr>';
                                        $contador++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                            <div>
                                <button type="submit" class="btn btn-primary" name="BotonGuardar">Guardar</button>
                                <button type="submit" class="btn btn-danger" name="BotonEliminar" onclick="return confirm('¿Estás seguro de que deseas eliminar esta orden de compra?')">Eliminar</button>
                                <a class="btn btn-light" href="listado_ordenCompra.php" role="button">Volver a Listado</a>
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