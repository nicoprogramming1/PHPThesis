<?php 
session_start();

if (empty($_SESSION['Usuario_Nombre'])) {
    header('Location: cerrarsesion.php');
    exit;
}

require_once 'funciones/conexion.php';
$MiConexion = ConexionBD(); 

require_once 'funciones/buscarEventoPorId.php';
require_once 'funciones/consulta_eventos_promotores.php';
require_once 'funciones/select_promotoresList.php';
require_once 'funciones/select_eventos.php';

$ListadoEventos = Listar_Eventos($MiConexion);
$CantidadEventos = count($ListadoEventos);

require_once 'funciones/validaciones.php';
$Mensaje = '';
$Estilo = 'warning';
if (!empty($_POST['BotonConsultar'])) {
    //estoy en condiciones de poder validar los datos
    $Mensaje = Validar_Seleccion_Consultas_Promotores();
}

require_once 'header.inc.php'; ?>

<!-- Incluir Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
    @media print {
        body * {
            visibility: hidden;
        }
        #printSection, #printSection * {
            visibility: visible;
        }
        #printSection {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
    }
</style>

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
                                <div class="form-group col-md-4">
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
                            <div style="display: flex;">
                                <table class="table" style="width: 40%; text-align:center; margin-right: 100px;">
                                    <thead>
                                        <tr>
                                            <?php require_once 'vercolumnas.eventos.consultas.inc.php'; ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $eventos = [];
                                        $asistentes = [];
                                        $totalAsistentes = 0; // Variable para almacenar el total de asistentes

                                        if (isset($_POST['promotores'])) {
                                            $selectedPromotor = $_POST['promotores'];

                                            if (!empty($selectedPromotor)) {
                                                // Mostrar eventos con la cantidad de asistentes referidos por el promotor
                                                $query = "SELECT e.idEvento, e.detalleEvento, e.fechaEvento, COUNT(ae.asistente) AS countAsistentes
                                                          FROM asistentes_evento AS ae
                                                          INNER JOIN evento AS e ON ae.idevento = e.idEvento
                                                          WHERE ae.idPromotorReferido = ?
                                                          GROUP BY e.idEvento, e.detalleEvento, e.fechaEvento
                                                          ORDER BY countAsistentes DESC";
                                                $stmt = $MiConexion->prepare($query);
                                                $stmt->bind_param('i', $selectedPromotor);
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

                                                        $eventos[] = $row['detalleEvento'];
                                                        $asistentes[] = $row['countAsistentes'];
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
                                <!-- Aquí quiero el gráfico de barras con un style inline de width 45% -->
                                <div style="width: 45%;" id="chart-container">
                                    <canvas id="myChart"></canvas>
                                </div>
                            </div>
                            <!-- Mostrar el valor total de asistentes -->
                            <div class="total-asistentes">
                                <strong>Total asistentes:</strong> <?php echo $totalAsistentes; ?>
                            </div>
                            <tr>
                                <button type="button" class="btn btn-primary" onclick="printSection()">Imprimir</button>
                            </tr>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Sección de impresión oculta -->
<div id="printSection" style="display:none;">
    <h5>Administración de asistentes</h5>
    <table class="table" style="width: 100%; text-align:center;">
        <thead>
            <tr>
                <?php require_once 'vercolumnas.eventos.consultas.inc.php'; ?>
            </tr>
        </thead>
        <tbody>
            <?php
            // Copiar el contenido de la tabla original aquí
            if (isset($_POST['promotores'])) {
                $selectedPromotor = $_POST['promotores'];

                if (!empty($selectedPromotor)) {
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        $contador = 1;
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<tr>';
                            echo '<td>' . $contador . '</td>';
                            echo '<td>' . $row['idEvento'] . '</td>';
                            echo '<td>' . $row['detalleEvento'] . '</td>';
                            $fechaEventoFormateada = date('d/m/Y', strtotime($row['fechaEvento']));
                            echo '<td>' . $fechaEventoFormateada . '</td>';
                            echo '<td>' . $row['countAsistentes'] . '</td>';
                            echo '</tr>';
                            $contador++;
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
    <canvas id="printChart" width="100%"></canvas>
</div>

<?php require_once 'footer.inc.php'; ?>
<?php require_once 'funciones/script.imprimir.inc.php'; ?>

<script>
    function renderChart(eventos, asistentes, chartId) {
        const ctx = document.getElementById(chartId).getContext('2d');
        const data = {
            labels: eventos,
            datasets: [{
                label: 'Asistentes por Evento',
                data: asistentes,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        };
        const config = {
            type: 'bar',
            data: data,
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        };
        new Chart(ctx, config);
    }

    // Llamar a la función renderChart al cargar la página si hay datos
    <?php if (!empty($eventos) && !empty($asistentes)): ?>
        renderChart(<?php echo json_encode($eventos); ?>, <?php echo json_encode($asistentes); ?>, 'myChart');
    <?php endif; ?>

    function printSection() {
        const printSection = document.getElementById('printSection');
        const chartData = <?php echo json_encode(['eventos' => $eventos, 'asistentes' => $asistentes]); ?>;

        // Renderizar el gráfico de la sección de impresión
        renderChart(chartData.eventos, chartData.asistentes, 'printChart');

        // Mostrar la sección de impresión
        printSection.style.display = 'block';

        // Esperar un momento para que el gráfico se renderice correctamente antes de imprimir
        setTimeout(() => {
            window.print();
            printSection.style.display = 'none';
        }, 1000);
    }
</script>
