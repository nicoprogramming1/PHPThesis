<?php 
session_start();

if (empty($_SESSION['Usuario_Nombre'])) {
    header('Location: cerrarsesion.php');
    exit;
}

require_once 'funciones/conexion.php';
$MiConexion = ConexionBD();

require_once 'funciones/actualizar_promotores.php';
require_once 'funciones/buscarNombrePromotorPorId.php';
require_once 'funciones/buscarApellidoPromotorPorId.php';
require_once 'funciones/eliminarPromotorPorId.php';
require_once 'funciones/validaciones.php';

$Mensaje = '';
$Estilo = 'warning';

if (isset($_POST['BotonGuardar'])) {
    $Mensaje = Validar_Modificar_Promotores();
    if (empty($Mensaje)) {
        // Obtener el nuevo nombre y apellido del promotor desde el formulario
        $nuevoNombrePromotor = $_POST['nuevoNombrePromotor'];
        $nuevoApellidoPromotor = $_POST['nuevoApellidoPromotor'];

        // Obtener el ID del promotor seleccionado (solo debe haber un ID seleccionado)
        $promotorSeleccionado = $_GET['id'];

        // Realizar la modificación del promotor en la base de datos
        if (ModificarPromotores($MiConexion, $promotorSeleccionado, $nuevoNombrePromotor, $nuevoApellidoPromotor)) {
            $Mensaje = 'Se ha modificado correctamente el promotor.';
            $Estilo = 'success';
        } else {
            $Mensaje = 'Error al modificar el promotor.';
            $Estilo = 'danger';
        }
    }
}

if (isset($_POST['BotonEliminar'])) {
    // Obtener el ID del promotor seleccionado (solo debe haber un ID seleccionado)
    $promotorSeleccionado = $_GET['id'];

    // Realizar la eliminación del promotor en la base de datos
    if (EliminarPromotor($MiConexion, $promotorSeleccionado)) {
        $Mensaje = 'Se ha eliminado correctamente el promotor.';
        $Estilo = 'success';
        // Redirigir a la lista de promotores después de la eliminación exitosa
        header('Location: listado_promotores.php');
        exit;
    } else {
        $Mensaje = 'Error al eliminar el promotor.';
        $Estilo = 'danger';
    }
}

if (isset($_GET['id'])) {
    $promotorSeleccionado = $_GET['id'];
    $nombrePromotor = ObtenerNombrePromotorPorID($MiConexion, $promotorSeleccionado);
    $apellidoPromotor = ObtenerApellidoPromotorPorID($MiConexion, $promotorSeleccionado);
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
                                <h5 class="m-b-10">Modificar Promotor</h5>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                <li class="breadcrumb-item"><a href="#!">Modificar Promotor</a></li>
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
                                    <label for="nuevoNombrePromotor">Nombre:</label>
                                    <input type="text" class="form-control" id="nuevoNombrePromotor" name="nuevoNombrePromotor" value="<?php echo $nombrePromotor; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="nuevoApellidoPromotor">Apellido:</label>
                                    <input type="text" class="form-control" id="nuevoApellidoPromotor" name="nuevoApellidoPromotor" value="<?php echo $apellidoPromotor; ?>">
                                </div>
                                <button type="submit" class="btn btn-primary" name="BotonGuardar">Guardar</button>
                                <button type="submit" class="btn btn-danger" name="BotonEliminar" onclick="return confirm('¿Estás seguro de que deseas eliminar este promotor?')">Eliminar</button>
                                <a class="btn btn-light" href="listado_promotores.php" role="button">Volver a Listado</a>
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