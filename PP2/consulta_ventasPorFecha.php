<?php 
session_start();

if (empty($_SESSION['Usuario_Nombre'])) {
    header('Location: cerrarsesion.php');
    exit;
}

require_once 'funciones/conexion.php';
$MiConexion = ConexionBD(); 

require_once 'funciones/buscarEventoPorId.php';
require_once 'funciones/select_eventos.php';
$ListadoEventos = Listar_Eventos($MiConexion);
$CantidadEventos = count($ListadoEventos);

require_once 'funciones/validaciones.php';
$Mensaje = '';
$Estilo = 'warning';

if (!empty($_POST['BotonConsultar'])) {
    // Estoy en condiciones de validar los datos
    $Mensaje = Validar_Seleccion_Consultas_VentasPorFecha();
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
                                <h5 class="m-b-10">Administración de ventas</h5>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                <li class="breadcrumb-item"><a href="#!">Consultas de ventas por fecha</a></li>
                            </ul>

                            <div class="card-body table-border-style">
                                <div class="card-body table-border-style">
                                    <?php require_once 'alertas.inc.php'; ?>
                                    <form role="form" method="post">

                                        <div class="row">
                                            <div class="form-group col-md-4">
                                                <label for="fechaVenta1" class="form-label">Fecha 1</label>
                                                <input type="date" id="fechaVenta1" name="fechaVenta1" class="form-control" required>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label for="fechaVenta2" class="form-label">Fecha 2</label>
                                                <input type="date" id="fechaVenta2" name="fechaVenta2" class="form-control" required>
                                            </div>

                                            <div class="form-group col-md-2">
                                                <button type="submit" class="btn btn-primary" name="BotonConsultar">Consultar</button>
                                                <input type="hidden" name="BotonConsultar" value="1">
                                            </div>
                                        </div>
                                        <table class="table table-responsive"  style="overflow-y: auto; max-height: 400px;">
                                            <thead>
                                                <tr>
                                                    <?php require_once 'vercolumnas.ventas.consultasPorFecha.inc.php'; ?>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            if (!empty($_POST['BotonConsultar'])) {
                                                $selectedFecha1 = $_POST['fechaVenta1'];
                                                $selectedFecha2 = $_POST['fechaVenta2'];

                                                // Consulta SQL para obtener las ventas entre las fechas seleccionadas
                                                $sql = "SELECT v.idVenta, u.apellido, v.fechaVenta, dt.totalVenta, e.detalleEvento
                                                        FROM venta v
                                                        INNER JOIN detalle_venta dt ON v.idVenta = dt.idVenta
                                                        INNER JOIN evento e ON dt.idEvento = e.idEvento
                                                        INNER JOIN usuarios u ON v.idCajero = u.idUsuario
                                                        WHERE v.fechaVenta BETWEEN '$selectedFecha1' AND '$selectedFecha2'
                                                        ORDER BY v.fechaVenta DESC";

                                                // Ejecutar la consulta y procesar los resultados
                                                $result = mysqli_query($MiConexion, $sql);
                                            }
                                            else {
                                                $sql = "SELECT v.idVenta, u.apellido, v.fechaVenta, dt.totalVenta, e.detalleEvento
                                                        FROM venta v
                                                        INNER JOIN detalle_venta dt ON v.idVenta = dt.idVenta
                                                        INNER JOIN evento e ON dt.idEvento = e.idEvento
                                                        INNER JOIN usuarios u ON v.idCajero = u.idUsuario
                                                        ORDER BY v.fechaVenta DESC";

                                                // Ejecutar la consulta y procesar los resultados
                                                $result = mysqli_query($MiConexion, $sql);
                                            }

                                                if ($result) {
                                                    $contador = 1;
                                                    // Iterar sobre los resultados y mostrar la lista de ventas
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        // Aquí puedes mostrar cada fila de la consulta como desees
                                                        echo '<tr>';
                                                        echo '<td>' . $contador . '</td>';
                                                        echo '<td>' . $row['idVenta'] . '</td>';
                                                        echo '<td>' . $row['apellido'] . '</td>';
                                                        echo '<td>' . $row['fechaVenta'] . '</td>';
                                                        echo '<td>' . '$ ' . $row['totalVenta'] . '</td>';
                                                        echo '<td>' . $row['detalleEvento'] . '</td>';
                                                        echo '</tr>';
                                                    }
                                                } else {
                                                    // Manejar cualquier error de consulta
                                                    echo "Error al ejecutar la consulta: " . mysqli_error($MiConexion);
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                    <?php require_once 'boton.imprimir.inc.php'; ?>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php require_once 'footer.inc.php'; ?>
    <?php require_once 'funciones/script.imprimir.inc.php'; ?>
</body>
</html>