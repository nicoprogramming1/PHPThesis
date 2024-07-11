<?php 
session_start();

if (empty($_SESSION['Usuario_Nombre'])) {
    header('Location: cerrarsesion.php');
    exit;
}

require_once 'funciones/conexion.php';
$MiConexion = ConexionBD(); 

require_once 'funciones/buscarEventoPorId.php';
require_once 'funciones/consulta_ventas_evento.php';
require_once 'funciones/select_eventos.php';
$ListadoEventos = Listar_Eventos($MiConexion);
$CantidadEventos = count($ListadoEventos);

require_once 'funciones/validaciones.php';
$Mensaje = '';
$Estilo = 'warning';

if (!empty($_POST['BotonConsultar'])) {
    // Estoy en condiciones de validar los datos
    $Mensaje = Validar_Seleccion_Consultas_Eventos();
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
                                <li class="breadcrumb-item"><a href="#!">Consultas de ventas por evento</a></li>
                            </ul>

                            <div class="card-body table-border-style">
                                <?php require_once 'alertas.inc.php'; ?>
                                <form role="form" method="post">
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label for="eventos" class="form-label">Eventos</label>
                                            <select class="form-control" name="eventos" id="Eventos">
                                                <option value="">Seleccionar evento</option>
                                                <option value="todos">Todos los eventos</option>
                                                <?php
                                                foreach ($ListadoEventos as $evento) {
                                                    echo '<option value="' . $evento['IDEVENTO'] . '">' . $evento['DETALLEEVENTO'] . ' | Fecha: ' . $evento['FECHAEVENTO'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <button type="submit" class="btn btn-primary" name="BotonConsultar">Consultar</button>
                                            <input type="hidden" name="BotonConsultar" value="1">
                                        </div>
                                    </div>
                                </form>
                                <div style="display: flex; gap:100px;">
                                    <table class="table" style="width: 40%;">
                                        <thead>
                                            <tr>
                                                <?php require_once 'vercolumnas.ventas.consultas.inc.php'; ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (!empty($_POST['BotonConsultar'])) {
                                                $selectedEvento = $_POST['eventos'];
                                                $contador = 1;
                                                if ($selectedEvento === "todos") {
                                                    foreach ($ListadoEventos as $evento) {
                                                        echo '<tr>';
                                                        echo '<td>' . $contador . '</td>';
                                                        echo '<td>' . $evento['IDEVENTO'] . '</td>';
                                                        echo '<td>' . $evento['DETALLEEVENTO'] . '</td>';
                                                        // Formatear la fechaEvento a dd/mm/aaaa antes de imprimir en la tabla
                                                        $fechaEventoFormateada = date('d/m/Y', strtotime($evento['FECHAEVENTO']));
                                                        echo '<td>' . $fechaEventoFormateada . '</td>';
                                                        echo '<td>' . countVentasEvento($MiConexion, $evento['IDEVENTO']) . '</td>';
                                                        echo '<td>' . totalVentasEvento($MiConexion, $evento['IDEVENTO']) . '</td>';
                                                        echo '</tr>';
                                                        $contador++;
                                                    }
                                                } else if (!empty($selectedEvento)) {
                                                    // Mostrar detalles del evento seleccionado
                                                    $contenidoEvento = ObtenerEventoPorId($MiConexion, $selectedEvento);
                                                    if ($contenidoEvento) {
                                                        echo '<tr>';
                                                        echo '<td>1</td>';
                                                        echo '<td>' . $contenidoEvento['IDEVENTO'] . '</td>';
                                                        echo '<td>' . $contenidoEvento['DETALLEEVENTO'] . '</td>';
                                                        // Formatear la fechaEvento a dd/mm/aaaa antes de imprimir en la tabla
                                                        $fechaEventoFormateada = date('d/m/Y', strtotime($contenidoEvento['FECHAEVENTO']));
                                                        echo '<td>' . $fechaEventoFormateada . '</td>';
                                                        echo '<td>' . countVentasEvento($MiConexion, $contenidoEvento['IDEVENTO']) . '</td>';
                                                        echo '<td>' . totalVentasEvento($MiConexion, $contenidoEvento['IDEVENTO']) . '</td>';
                                                        echo '</tr>';
                                                    } else {
                                                        echo '<tr>';
                                                        echo '<td colspan="5">No hay datos para este evento.</td>';
                                                        echo '</tr>';
                                                    }
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                    <?php
                                    if (!empty($_POST['BotonConsultar'])) {
                                        $selectedEvento = $_POST['eventos'];
                                        if ($selectedEvento === "todos") {
                                            echo "  <div style='display:flex; flex-wrap:wrap'>
                                                        <div style='width: 100%;'>
                                                            <canvas id='myChart'></canvas>
                                                        </div></br>
                                                        <!-- Botón e función de impresión -->
                                                        <div style='margin-top: 20px; margin-left: auto; margin-right: 100px;'>
                                                            <button class='btn btn-secondary' onclick='printSection()'>Imprimir</button>
                                                        </div>
                                                    </div>";
                                            }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div id="printSection" style="display:none;">
        <h5 class="m-b-10">Administración de ventas</h5>
        <table class="table" style="width: 100%;">
            <thead>
                <tr>
                    <?php require_once 'vercolumnas.ventas.consultas.inc.php'; ?>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($_POST['BotonConsultar'])) {
                    $selectedEvento = $_POST['eventos'];
                    $contador = 1;
                    if ($selectedEvento === "todos") {
                        foreach ($ListadoEventos as $evento) {
                            echo '<tr>';
                            echo '<td>' . $contador . '</td>';
                            echo '<td>' . $evento['IDEVENTO'] . '</td>';
                            echo '<td>' . $evento['DETALLEEVENTO'] . '</td>';
                            // Formatear la fechaEvento a dd/mm/aaaa antes de imprimir en la tabla
                            $fechaEventoFormateada = date('d/m/Y', strtotime($evento['FECHAEVENTO']));
                            echo '<td>' . $fechaEventoFormateada . '</td>';
                            echo '<td>' . countVentasEvento($MiConexion, $evento['IDEVENTO']) . '</td>';
                            echo '<td>' . $ganancia[totalVentasEvento($MiConexion, $evento['IDEVENTO'])] . '</td>';
                            echo '</tr>';
                            $contador++;
                        }
                    }
                }
                ?>
            </tbody>
        </table>
        <canvas id="printChart" width="100%"></canvas>
    </div>

    <?php require_once 'footer.inc.php'; ?>
    
    <!-- Script para Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    var eventos = [];
    var ganancias = [];

    <?php
    foreach ($ListadoEventos as $evento) {
        $eventoId = $evento['IDEVENTO'];
        $nombreEvento = $evento['DETALLEEVENTO'];
        $gananciaEvento = totalVentasEvento($MiConexion, $eventoId);

        echo "eventos.push('$nombreEvento');";
        echo "ganancias.push($gananciaEvento);";
    }
    ?>

    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: eventos,
            datasets: [{
                label: 'Ganancia por Evento',
                data: ganancias,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    function printSection() {
        const printSection = document.getElementById('printSection');
        const chartData = <?php echo json_encode(['eventos' => $eventos, 'ganancias' => $ganancias]); ?>;

        // Renderizar el gráfico de la sección de impresión
        var ctxPrint = document.getElementById('printChart').getContext('2d');
        var myPrintChart = new Chart(ctxPrint, {
            type: 'bar',
            data: {
                labels: chartData.eventos,
                datasets: [{
                    label: 'Ganancia por Evento',
                    data: chartData.ganancias,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Mostrar la sección de impresión
        printSection.style.display = 'block';

        // Esperar un momento para que el gráfico se renderice correctamente antes de imprimir
        setTimeout(() => {
            window.print();
            printSection.style.display = 'none';
        }, 1000);
    }
</script>
</body>
</html>
