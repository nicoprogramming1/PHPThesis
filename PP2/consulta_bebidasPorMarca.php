<?php 
session_start();

if (empty($_SESSION['Usuario_Nombre'])) {
    header('Location: cerrarsesion.php');
    exit;
}

require_once 'funciones/conexion.php';
$MiConexion=ConexionBD(); 

require_once 'funciones/buscarBebidaPorMarca.php';

require_once 'funciones/select_bebidas.php';
$ListadoBebidas = Listar_Bebidas($MiConexion);
$CantidadBebidas = count($ListadoBebidas);

require_once 'funciones/buscarMarcaPorId.php';

require_once 'funciones/select_marcas.php';
$ListadoMarcas = Listar_Marcas($MiConexion);
$CantidadMarcas = count($ListadoMarcas);

require_once 'funciones/validaciones.php';
$Mensaje='';
$Estilo='warning';

if (!empty($_POST['BotonConsultar'])) {
    // Estoy en condiciones de poder validar los datos
    $Mensaje = Validar_Seleccion_Consultas_Marcas();
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
                <a href="index.php" class="b-brand">
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
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item"><a href="#!">Consultas de bebidas</a></li>
                        </ul>

                    <div class="card-body table-border-style">
                        <?php require_once 'alertas.inc.php'; ?>
                        <form role="form" method="post" style="width: 100%;">
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="marca" class="form-label">Marcas</label>
                                    <select class="form-control" name="marca" id="marca">
                                        <option value="">Seleccionar marca</option>
                                        <option value="todos">Todas las marcas</option>
                                        <?php
                                        foreach ($ListadoMarcas as $marca) {
                                            echo '<option value="' . $marca['IDMARCA'] . '">Id: ' . $marca['IDMARCA'] . ' | ' . $marca['MARCA'] . '</option>';
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
                                        <?php require_once 'vercolumnas.bebidasConsultaPorMarca.inc.php'; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $bebidas = [];
                                    $volumenes = [];
                                    if (!empty($_POST['BotonConsultar'])) {
                                        $selectedMarca = $_POST['marca'];
                                        $contador = 1;
                                        
                                        if ($selectedMarca === "todos") {
                                            foreach ($ListadoBebidas as $bebida) {
                                                echo '<tr>';
                                                echo '<td>' . $contador . '</td>';
                                                echo '<td>' . $bebida['IDBEBIDA'] . '</td>';
                                                echo '<td>' . $bebida['BEBIDA'] . '</td>';
                                                echo '<td>' . $bebida['VOLUMEN'] . '</td>';
                                                echo '</tr>';
                                                $bebidas[] = $bebida['BEBIDA'];
                                                $volumenes[] = $bebida['VOLUMEN'];
                                                $contador++;
                                            }
                                        } else if (!empty($selectedMarca)) {
                                            $detalleBebida = ObtenerBebidaPorMarca($MiConexion, $selectedMarca);
                                            
                                            if ($detalleBebida) {
                                                echo '<tr>';
                                                echo '<td>' . $contador . '</td>';
                                                echo '<td>' . $detalleBebida['IDBEBIDA'] . '</td>';
                                                echo '<td>' . $detalleBebida['BEBIDA'] . '</td>';
                                                echo '<td>' . $detalleBebida['VOLUMEN'] . '</td>';
                                                echo '</tr>';
                                                $bebidas[] = $detalleBebida['BEBIDA'];
                                                $volumenes[] = $detalleBebida['VOLUMEN'];
                                                $contador++;
                                            } else {
                                                echo '<tr>';
                                                echo '<td colspan="7">No hay datos para esta bebida.</td>';
                                                echo '</tr>';
                                            }
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <?php
                                if (!empty($_POST['BotonConsultar'])) {
                                    $selectedMarca = $_POST['marca'];
                                    if ($selectedMarca === "todos") {
                                        echo "  <div style='display:flex; flex-wrap:wrap; margin-right: 100px;'>
                                                <div style='width: 100%;'>
                                                    <canvas id='myChart'></canvas>
                                                </div></br>
                                                <!-- Botón e función de impresión -->
                                                <div style='margin-top: 20px; margin-left: auto; margin-right: 100px;'>
                                                    <button class='btn btn-secondary' onclick='printPage()'>Imprimir</button>
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
</section>

<!-- Script para Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var bebida = [];
    var volumen = [];

    <?php
        foreach ($ListadoBebidas as $bebida) {
            $bebidaId = $bebida['IDBEBIDA'];
            $nombreBebida = $bebida['BEBIDA'];
            $volumen = $bebida['VOLUMEN'];

            echo "bebida.push('$nombreBebida');";
            echo "volumen.push($volumen);";
        }
    ?>

    // Renderiza el gráfico en la página
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: bebida,
            datasets: [{
                label: 'Volumen por bebida',
                data: volumen,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 0.5
                    }
                }
            }
        }
    });

    function printPage() {
        // Esperar a que el gráfico se haya renderizado completamente
        myChart.update(); // Asegurar que el gráfico esté actualizado antes de imprimir

        // Imprimir la página directamente
        window.print();
    }
</script>

</body>
</html>
