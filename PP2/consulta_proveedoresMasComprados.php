<?php 
session_start();

if (empty($_SESSION['Usuario_Nombre'])) {
    header('Location: cerrarsesion.php');
    exit;
}

require_once 'funciones/conexion.php';
$MiConexion=ConexionBD(); 

// Consulta SQL para obtener la lista de proveedores ordenados por cantidad de compras
$SQL = "SELECT
    P.idProveedor,
    P.nombreProveedor,
    COUNT(DC.idCompra) AS cantidad_compras
FROM
    proveedor P
LEFT JOIN
    orden_compra OC ON P.idProveedor = OC.idProveedor
LEFT JOIN
    detalle_compra DC ON OC.idOrdenCompra = DC.idOrdenCompra
GROUP BY
    P.idProveedor, P.nombreProveedor
ORDER BY
    cantidad_compras DESC";

$rs = mysqli_query($MiConexion, $SQL);

$Mensaje='';
$Estilo='warning';

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
                                <li class="breadcrumb-item"><a href="#!">Consulta de proveedores más comprados</a></li>
                            </ul>

                            <div class="card-body table-border-style" id="printSection" style="display: flex;">
                                <?php require_once 'alertas.inc.php'; ?>
                                <form role="form" method="post">
                                    <div class="row">
                                        <table class="table" style="width: 40%;">
                                            <thead>
                                                <tr>
                                                    <?php require_once 'vercolumnas.proveedoresConcurridos.inc.php'; ?>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                // Verifica si se ejecutó correctamente la consulta
                                                $proveedores = [];
                                                $compras = [];
                                                if ($rs) {
                                                    while ($data = mysqli_fetch_array($rs)) {
                                                        echo '<tr>';
                                                        echo '<td>' . $data['idProveedor'] . '</td>';
                                                        echo '<td>' . $data['nombreProveedor'] . '</td>';
                                                        echo '<td>' . $data['cantidad_compras'] . '</td>';
                                                        echo '</tr>';
                                                        // Agrega los datos al arreglo para el gráfico
                                                        $proveedores[] = $data['nombreProveedor'];
                                                        $compras[] = $data['cantidad_compras'];
                                                    }
                                                }
                                                ?>                                 
                                            </tbody>
                                        </table>
                                        <div class="col-md-12">
                                            <a class="btn btn-light" href="index.php" role="button">Volver a Home</a>
                                            <button type="button" class="btn btn-secondary" onclick="showPrintModal()">Imprimir</button>
                                        </div>
                                    </div>
                                </form>
                                <div style="width: 50%;">
                                    <canvas id="myChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php require_once 'footer.inc.php'; ?>

    <!-- Modal -->
    <div class="modal" id="printModal" tabindex="-1" role="dialog" aria-labelledby="printModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="printModalLabel">Vista de impresión</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="printableContent">
                    <table class="table">
                        <thead>
                            <tr>
                                <?php require_once 'vercolumnas.proveedoresConcurridos.inc.php'; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            mysqli_data_seek($rs, 0); // Resetear el puntero de resultados
                            if ($rs) {
                                while ($data = mysqli_fetch_array($rs)) {
                                    echo '<tr>';
                                    echo '<td>' . $data['idProveedor'] . '</td>';
                                    echo '<td>' . $data['nombreProveedor'] . '</td>';
                                    echo '<td>' . $data['cantidad_compras'] . '</td>';
                                    echo '</tr>';
                                }
                            }
                            ?>                                 
                        </tbody>
                    </table>
                    <canvas id="printChart"></canvas>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" onclick="printContent()">Imprimir</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Script para Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var proveedores = <?php echo json_encode($proveedores); ?>;
        var compras = <?php echo json_encode($compras); ?>;

        // Renderiza el gráfico en la página
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: proveedores,
                datasets: [{
                    label: 'Concurrencia por proveedor',
                    data: compras,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                },
                maintainAspectRatio: false,
                responsive: true
            }
        });

        function showPrintModal() {
            // Mostrar la ventana modal
            $('#printModal').modal('show');

            // Renderiza el gráfico de la sección de impresión
            var ctxPrint = document.getElementById('printChart').getContext('2d');
            var myPrintChart = new Chart(ctxPrint, {
                type: 'bar',
                data: {
                    labels: proveedores,
                    datasets: [{
                        label: 'Concurrencia por proveedor',
                        data: compras,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
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
            });
        }

        function printContent() {
            // Ocultar la ventana modal
            $('#printModal').modal('hide');

            // Esperar un momento para que la ventana modal se oculte antes de imprimir
            setTimeout(() => {
                window.print();
            }, 500);
        }
    </script>
</body>
</html>
