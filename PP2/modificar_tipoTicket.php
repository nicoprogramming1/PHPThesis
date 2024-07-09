<?php 
session_start();

if (empty($_SESSION['Usuario_Nombre'])) {
    header('Location: cerrarsesion.php');
    exit;
}

require_once 'funciones/conexion.php';
$MiConexion = ConexionBD();

require_once 'funciones/actualizar_tipoTickets.php';
require_once 'funciones/buscarTipoTicketPorId.php';
require_once 'funciones/validaciones.php';
require_once 'funciones/eliminarTipoTicket.php';
require_once 'funciones/select_bebidasList.php';

// Obtener el ID del tipo de ticket seleccionado desde la URL
if (isset($_GET['id'])) {
    $idTipoTicketSeleccionado = $_GET['id'];
} else {
    // Si no se proporcionó el ID, redirigir al listado de asistentes
    header('Location: listado_tipoTickets.php');
    exit;
}

// Obtener los datos del tipo de ticket seleccionado
$datosTipoTicket = ObtenerTipoTicketPorID($MiConexion, $idTipoTicketSeleccionado);

// Verificar si el tipo de ticket existe y mostrar mensaje si no se encontró
if (!$datosTipoTicket) {
    $Mensaje = 'El tipo de ticket seleccionado no existe.';
    $Estilo = 'danger';
    $datosTipoTicket = array(); // Inicializar los datos vacíos
}

$Mensaje = '';
$Estilo = 'warning';

if (isset($_POST['BotonGuardar'])) {
    $Mensaje = Validar_Modificar_TipoTicket();
    if (empty($Mensaje)) {
        // Obtener los nuevos datos del tipo de ticket desde el formulario
        $nuevoTipoTicket = $_POST['nuevoTipoTicket'];
        $nuevoPrecioTipoTicket = $_POST['nuevoPrecioTicket'];
        $nuevoPrimeraBebida = $_POST['nuevaPrimeraBebida'];
        $nuevoSegundaBebida = $_POST['nuevaSegundaBebida'];

        // Realizar la modificación del tipo de ticket en la base de datos
        if (ModificarTipoTicket($MiConexion, $idTipoTicketSeleccionado, $nuevoTipoTicket, $nuevoPrecioTipoTicket, $nuevoPrimeraBebida, $nuevoSegundaBebida)) {
            $Mensaje = 'Se ha modificado correctamente el tipo de ticket.';
            $Estilo = 'success';
        } else {
            $Mensaje = 'Error al modificar el tipo de ticket.';
            $Estilo = 'danger';
        }
    }
}

if (isset($_POST['BotonEliminar'])) {

    // Realizar la eliminación del tipo de ticket en la base de datos
    if (EliminarTipoTicket($MiConexion, $idTipoTicketSeleccionado)) {
        $Mensaje = 'Se ha eliminado correctamente el tipo de ticket.';
        $Estilo = 'success';
        // Redirigir a la lista de tipo de ticket después de la eliminación exitosa
        header('Location: listado_tipoTickets.php');
        exit;
    } else {
        $Mensaje = 'Error al eliminar el tipo de ticket.';
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
                            <h5 class="m-b-10">Administración de Ventas</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item"><a href="#!">Modificar tipo de ticket</a></li>
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
                        
                        <form method="post">
                            <div class="form-group">
                                <label for="nuevoTipoTicket">Tipo de ticket:</label>
                                <input type="text" class="form-control" id="nuevoTipoTicket" name="nuevoTipoTicket" value="<?php echo $datosTipoTicket['tipoTicket']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="nuevoPrecioTicket">Precio:</label>
                                <input type="text" class="form-control" id="nuevoPrecioTicket" name="nuevoPrecioTicket" value="<?php echo $datosTipoTicket['precioTicket']; ?>">
                            </div>
                            <div class="col-md-6">
                            <div class="form-group">
                                <label for="nuevaPrimeraBebida" class="form-label">Bebida 1 (*)</label>
                                <select class="form-control" name="nuevaPrimeraBebida" id="nuevaPrimeraBebida">
                                    <option value="<?php echo $datosTipoTicket['bebida1']; ?>">Seleccionar primer bebida</option>
                                    <?php
                                    $bebidasList = ObtenerListaBebidas($MiConexion);
                                    foreach ($bebidasList as $bebida) {
                                        // Verificar si el ID de la bebida coincide con la bebida asociada al tipo de ticket
                                        $selected = ($bebida['idBebida'] == $datosTipoTicket['idBebida1']) ? 'selected' : '';
                                        echo '<option value="' . $bebida['idBebida'] . '" ' . $selected . '>' . $bebida['bebida'] . ' | ' . $bebida['marca'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="nuevaSegundaBebida" class="form-label">Bebida 2 (*)</label>
                                <select class="form-control" name="nuevaSegundaBebida" id="nuevaSegundaBebida">
                                    <option value="">Seleccionar segunda bebida</option>
                                    <?php
                                    foreach ($bebidasList as $bebida) {
                                        // Verificar si el ID de la bebida coincide con la bebida asociada al tipo de ticket
                                        $selected = ($bebida['idBebida'] == $datosTipoTicket['idBebida2']) ? 'selected' : '';
                                        echo '<option value="' . $bebida['idBebida'] . '" ' . $selected . '>' . $bebida['bebida'] . ' | ' . $bebida['marca'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-primary" name="BotonGuardar">Guardar</button>
                                <button type="submit" class="btn btn-danger" name="BotonEliminar" onclick="return confirm('¿Estás seguro de que deseas eliminar este tipo de ticket?')">Eliminar</button>
                                <a class="btn btn-light" href="listado_tipoTickets.php" role="button">Volver a Listado</a>
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