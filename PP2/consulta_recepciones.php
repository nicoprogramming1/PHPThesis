<?php 
session_start();

if (empty($_SESSION['Usuario_Nombre'])) {
    header('Location: cerrarsesion.php');
    exit;
}

require_once 'funciones/conexion.php';
$MiConexion=ConexionBD(); 

require_once 'funciones/buscarRecepcionPorId.php';

require_once 'funciones/select_recepcionesListadoRecepciones.php';
$ListadoRecepciones = Listar_Recepciones($MiConexion);
$CantidadRecepciones = count($ListadoRecepciones);

require_once 'funciones/validaciones.php';
$Mensaje='';
$Estilo='warning';

if (!empty($_POST['BotonConsultar'])) {
    // Estoy en condiciones de poder validar los datos
    $Mensaje = Validar_Seleccion_Consultas_Recepciones();
    
}

if (!empty($_POST['BotonVerDetalles'])) {
    //estoy en condiciones de poder validar los datos
    $Mensaje="";
    $Mensaje=Validar_Seleccion_Consultas_Recepciones_Detalles();
    if (empty($Mensaje)) {
        // Obtener los IDs de la recepción seleccionada
        $recepcionSeleccionada = $_POST['seleccionar'];

        // Redirigir a la página de modificación con los IDs seleccionados como parámetros
        header('Location: recepcion_seleccionada.php?id=' . implode(',', $recepcionSeleccionada));
        exit;
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
                            <h5 class="m-b-10">Administración de Stock</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item"><a href="#!">Consultas de recepciones de compra</a></li>
                        </ul>


                    <div class="card-body table-border-style">
                        <?php require_once 'alertas.inc.php'; ?>
                        <form role="form" method="post">
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="listaRecepciones" class="form-label">Recepciones</label>
                                    <select class="form-control" name="listaRecepciones" id="listaRecepciones">
                                        <option value="">Seleccionar recepción</option>
                                        <option value="todos">Todas las recepciones</option>
                                        <?php
                                        foreach ($ListadoRecepciones as $recepciones) {
                                            echo '<option value="' . $recepciones['IDRECEPCIONCOMPRA'] . '">Id: ' . $recepciones['IDRECEPCIONCOMPRA'] . ' | ' . $recepciones['FECHARECEPCIONCOMPRA'] . ' | ' . $recepciones['ESTADORECEPCIONCOMPRA'] . ' | ' . $recepciones['IDCOMPRA'] . '</option>';
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
                        <form role="form" method="post">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <?php require_once 'vercolumnas.recepcionesConsulta.inc.php'; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($_POST['BotonConsultar'])) {
                                        // Estoy en condiciones de poder validar los datos
                                        $selectedRecepcion = $_POST['listaRecepciones'];
                                        $contador = 1;
                                        
                                        if ($selectedRecepcion === "todos") {
                                            foreach ($ListadoRecepciones as $recepcion) {
                                                echo '<tr>';
                                                echo '<td>' . $contador . '</td>';
                                                echo '<td>' . $recepcion['IDRECEPCIONCOMPRA'] . '</td>';
                                                echo '<td>' . $recepcion['FECHARECEPCIONCOMPRA'] . '</td>';
                                                echo '<td>' . $recepcion['ESTADORECEPCIONCOMPRA'] . '</td>';
                                                echo '<td>' . $recepcion['IDCOMPRA'] . '</td>';
                                                echo '<td>' . '</td>';
                                                echo '<td><input type="radio" name="seleccionar[]" value="' . $recepcion['IDRECEPCIONCOMPRA'] . '"></td>';
                                                echo '</tr>';
                                                $contador++;
                                            }
                                        } else if (!empty($selectedRecepcion)) {
                                            $detalleRecepcion = ObtenerRecepcionPorId($MiConexion, $selectedRecepcion);
                                            
                                            if ($detalleRecepcion) {
                                                echo '<tr>';
                                                echo '<td>' . $contador . '</td>';
                                                echo '<td>' . $detalleRecepcion['IDRECEPCIONCOMPRA'] . '</td>';
                                                echo '<td>' . $detalleRecepcion['FECHARECEPCIONCOMPRA'] . '</td>';
                                                echo '<td>' . $detalleRecepcion['ESTADORECEPCION'] . '</td>';
                                                echo '<td>' . $detalleRecepcion['IDCOMPRA'] . '</td>';
                                                echo '<td>' . '</td>';
                                                echo '<td><input type="radio" name="seleccionar[]" value="' . $detalleRecepcion['IDRECEPCIONCOMPRA'] . '"></td>';
                                                echo '</tr>';
                                                $contador++;
                                            } else {
                                                echo '<tr>';
                                                echo '<td colspan="7">No hay datos para esta recepción.</td>';
                                                echo '</tr>';
                                            }
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <?php require_once 'boton.imprimir.inc.php'; ?>
                            <button class="btn btn-primary" type="submit" value="BotonVerDetalles" name="BotonVerDetalles" id="BotonVerDetalles">Ver detalles</button>
                            <a class="btn btn-light" href="index.php" role="button">Volver a Home</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php require_once 'footer.inc.php'; ?>
<?php require_once 'funciones/script.imprimir.inc.php'; ?>