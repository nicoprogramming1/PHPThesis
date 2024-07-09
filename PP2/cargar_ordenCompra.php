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
require_once 'funciones/select_proveedoresList.php';
require_once 'funciones/insertar_ordenCompra.php';

$ListadoBebidas = ObtenerListaBebidas($MiConexion);
$CantidadBebidas = count($ListadoBebidas);

$Mensaje = '';
$Estilo = 'warning';

if (!empty($_POST['BotonRegistrar'])) {
    // Estoy en condiciones de poder validar los datos
    $Mensaje = Validar_Datos_OrdenCompra();

    if (empty($Mensaje)) {
        // Si no hay errores de validación, proceder a registrar la orden de compra en la base de datos
        $proveedor = $_POST['proveedor'];

        $bebidas = array(); // Arreglo para almacenar las bebidas seleccionadas

        foreach ($_POST as $key => $value) {
            if (strpos($key, 'cantidad_') === 0) {
                // El nombre del campo comienza con "cantidad_", lo que significa que es una cantidad de bebida
                $idBebida = substr($key, 9); // Obtener el ID de la bebida
                $cantidad = (int)$value; // Convertir el valor a entero

                if ($cantidad > 0) {
                    // Si la cantidad es mayor que 0, se considera que la bebida está seleccionada
                    $bebidas[$idBebida] = $cantidad;
                }
            }
        }

        // Inserta la orden de compra y obtén su ID
        $idOrdenCompra = InsertarOrdenCompra($MiConexion, $proveedor);

        // Agrega las bebidas a la orden de compra
        foreach ($bebidas as $bebidaID => $cantidad) {
            InsertarDetalleOrdenCompra($MiConexion, $idOrdenCompra, $bebidaID, $cantidad);
        }

        $Mensaje = 'Se ha registrado correctamente la orden de compra.';
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
                            <h5 class="m-b-10">Administración de Compras</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                            <li class="breadcrumb-item"><a href="#!">Compras</a></li>
                            <li class="breadcrumb-item">Registrar Orden de Compra</li>
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
                        <h5>Registrar Orden de Compra</h5>
                        <hr>
                        <?php require_once 'alertas.inc.php'; ?>

                        <div class="alert alert-info" role="alert">
                            <i data-feather="info"></i>
                            Los campos con * son obligatorios.
                        </div>

            <form role="form" method="post">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="proveedor" class="form-label">Proveedor (*)</label>
                        <select class="form-control" name="proveedor" id="proveedor">
                            <option value="">Seleccionar proveedor</option>
                            <?php
                            $proveedoresList = ObtenerListaProveedores($MiConexion);
                            foreach ($proveedoresList as $proveedor) {
                                echo '<option value="' . $proveedor['idProveedor'] . '">' . $proveedor['nombreProveedor'] . ' (ID: ' . $proveedor['idProveedor'] . ')</option>';
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
                                echo '<tr>';
                                echo '<td>' . $contador . '</td>';
                                echo '<td>' . $bebida['bebida'] . ' - ' . $bebida['marca'] . '</td>';
                                echo '<td><input type="text" name="cantidad_' . $idBebida . '" value="0"></td>';
                                echo '</tr>';
                                $contador++;
                            }
                            ?>
                        </tbody>
                    </table>
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