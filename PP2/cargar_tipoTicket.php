<?php 
session_start();

if (empty($_SESSION['Usuario_Nombre'])) {
    header('Location: cerrarsesion.php');
    exit;
}

require_once 'funciones/conexion.php';
$MiConexion = ConexionBD(); 

require_once 'funciones/validaciones.php';

require_once 'funciones/select_bebidasList.php';
require_once 'funciones/insertar_tipoTicket.php';

$Mensaje = '';
$Estilo = 'warning';
if (!empty($_POST['BotonRegistrar'])) {
    // Estoy en condiciones de poder validar los datos
    $Mensaje = Validar_Datos_Registro_TipoTicket();
    if (empty($Mensaje)) {
        // Si no hay errores de validación, proceder a registrar el tipo de ticket en la base de datos
        $tipoTicket = $_POST['tipoTicket'];
        $precioTicket = floatval($_POST['precioTicket']);
        $idBebida1 = $_POST['primerBebida'];
        $idBebida2 = $_POST['segundaBebida'];

        InsertarTipoTicket($MiConexion, $tipoTicket, $precioTicket, $idBebida1, $idBebida2);
        
        $Mensaje = 'Se ha registrado correctamente el tipo de ticket.';
        $Estilo = 'success';
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
                            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                            <li class="breadcrumb-item"><a href="#!">Ventas</a></li>
                            <li class="breadcrumb-item">Registrar tipo de ticket</li>
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
                        <h5>Registrar Tipo de ticket</h5>
                        <hr>
                        <?php require_once 'alertas.inc.php'; ?>

                        <div class="alert alert-info" role="alert">
                            <i data-feather="info"></i>
                            Los campos con * son obligatorios.
                        </div>

            <form role="form" method="post">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="tipoTicket" class="form-label">Tipo de ticket (*)</label>
                            <input type="text" class="form-control" id="tipoTicket" placeholder="Ingresa el tipo de ticket" name="tipoTicket">
                        </div>
                        <div class="mb-3">
                            <label for="precioTicket" class="form-label">Precio de ticket (*)</label>
                            <input type="text" class="form-control" id="precioTicket" placeholder="Ingresa el precio del ticket" name="precioTicket">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="primerBebida" class="form-label">Bebida 1 (*)</label>
                            <select class="form-control" name="primerBebida" id="primerBebida">
                                <option value="">Seleccionar primer bebida</option>
                                 <?php
                                $bebidasList = ObtenerListaBebidas($MiConexion);
                                foreach ($bebidasList as $bebida1) {
                                    echo '<option value="' . $bebida1['idBebida'] . '">' . $bebida1['bebida'] . ' | ' . $bebida1['marca'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="segundaBebida" class="form-label">Bebida 2 (*)</label>
                            <select class="form-control" name="segundaBebida" id="segundaBebida">
                                <option value="">Seleccionar segunda bebida</option>
                                <?php
                                if (empty($bebidasList)) {
                                    echo 'No se encontraron bebidas disponibles';
                                } else {
                                    foreach ($bebidasList as $bebida1) {
                                        echo '<option value="' . $bebida1['idBebida'] . '">' . $bebida1['bebida'] . ' | ' . $bebida1['marca'] . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit" value="Registrar" name="BotonRegistrar">Registrar</button>
                            <a class="btn btn-light" href="index.php" role="button">Volver a Home</a>
                            <input class="btn btn-secondary" type="reset" value="Limpiar datos" name="BotonLimpiar">
                        </div>
                    </div>
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