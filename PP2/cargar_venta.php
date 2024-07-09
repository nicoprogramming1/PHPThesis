<?php
session_start();

date_default_timezone_set('America/Buenos_Aires');

if (empty($_SESSION['Usuario_Nombre'])) {
    header('Location: cerrarsesion.php');
    exit;
}

require_once 'funciones/conexion.php';
$MiConexion = ConexionBD(); 

require_once 'funciones/validaciones.php';
require_once 'funciones/select_tipoTickets.php';
$ListadoTipoTickets = Listar_tipoTickets($MiConexion);
$CantidadTipotickets = count($ListadoTipoTickets);

require_once 'funciones/restarBebidas.php';
require_once 'funciones/buscarBebidaPorId.php';

$Mensaje = '';
$Estilo = 'warning';

if (!empty($_POST['BotonRegistrar'])) {
    $Mensaje = Validar_Datos_Registro_Venta();
    if (empty($Mensaje)) {
        $horaVenta = date('H:i:s');
        $fechaVenta = date('Y-m-d');
        $idCajero = $_SESSION['Usuario_Id'];

        $totalVenta = 0;
        foreach ($ListadoTipoTickets as $ticket) {
            $idTipoTicket = $ticket['IDTIPOTICKET'];
            $cantidad = (int)$_POST['cantidad_' . $idTipoTicket];
            if ($cantidad > 0) {
                $precioTicket = (float)$ticket['PRECIOTICKET'];
                $totalVenta += $cantidad * $precioTicket;
            }
        }

        $queryBuscarEvento = "SELECT idEvento FROM evento ORDER BY fechaEvento DESC LIMIT 1";
        $resultadoEvento = mysqli_query($MiConexion, $queryBuscarEvento);
        $idEvento = null;
        if (mysqli_num_rows($resultadoEvento) > 0) {
            $filaEvento = mysqli_fetch_assoc($resultadoEvento);
            $idEvento = $filaEvento['idEvento'];
        }

        if ($idEvento === null) {
            $Mensaje = 'No hay evento registrado en la tabla evento.';
            $Estilo = 'danger';
        } else {
            $Mensaje = 'No hay evento registrado en la tabla evento.';
            $Estilo = 'danger';
        }

        if ($idEvento > 0) {
            $queryInsertVenta = "INSERT INTO venta (horaVenta, fechaVenta, idCajero) VALUES ('$horaVenta', '$fechaVenta', '$idCajero')";
            mysqli_query($MiConexion, $queryInsertVenta);

            $idVenta = mysqli_insert_id($MiConexion);

            $queryInsertDetalleVenta = "INSERT INTO detalle_venta (idVenta, totalVenta, idEvento) VALUES ('$idVenta', '$totalVenta', '$idEvento')";
            mysqli_query($MiConexion, $queryInsertDetalleVenta);

            $idDetalleVenta = mysqli_insert_id($MiConexion);

            foreach ($ListadoTipoTickets as $ticket) {
                $idTipoTicket = $ticket['IDTIPOTICKET'];
                $idBebidas[] = '';

                $idBebidas = ObtenerBebidaPorTipoTicketId($MiConexion, $idTipoTicket);

                $cantidadIngresadaBebida = (int)$_POST['cantidad_' . $idTipoTicket];

                if (is_array($idBebidas)) {
                    $idBebida1 = $idBebidas[0];
                    $idBebida2 = $idBebidas[1];
                    
                    restarBebidas2($MiConexion, $idBebida1, $idBebida2, $cantidadIngresadaBebida, $cantidadIngresadaBebida);
                }

                $queryInsertDetalleVentaTipoTicket = "INSERT INTO detalleventa_tipoticket (idDetalleVenta, idTipoTicket) VALUES ('$idDetalleVenta', '$idTipoTicket')";
                mysqli_query($MiConexion, $queryInsertDetalleVentaTipoTicket);
            }

            $Mensaje = 'Se ha registrado correctamente la venta.';
            $Estilo = 'success';

            echo '<script>imprimirTabla();</script>';
            echo '<script>imprimirFormulario();</script>';
        }
    } else {
        $Estilo = 'danger';
    }
}

require_once 'header.inc.php';
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function() {
    function actualizarTotal() {
      var total = 0;
      <?php foreach ($ListadoTipoTickets as $ticket) { ?>
        var cantidad = parseInt($('[name="cantidad_<?php echo $ticket['IDTIPOTICKET']; ?>"]').val());
        var precioTicket = parseFloat('<?php echo $ticket['PRECIOTICKET']; ?>');
        total += cantidad * precioTicket;
      <?php } ?>
      $('#total').text('Total: $ ' + total.toFixed(2));
    }

    $('input[name^="cantidad_"]').on('input', function() {
      actualizarTotal();
    });

    actualizarTotal();
  });
</script>

</head>
<body class="">
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>
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
            </a>
            <a href="#!" class="pc-head-link" id="header-collapse">
                <i data-feather="more-vertical"></i>
            </a>
        </div>
    </div>
    <nav class="pc-sidebar ">
        <div class="navbar-wrapper">
            <div class="m-header">
                <a href="index.html" class="b-brand">
                    <span>ELITE APP</span>
                </a>
            </div>
            <div class="navbar-content">
                 <?php require_once 'menu.inc.php'; ?>
            </div>
        </div>
    </nav>
    <header class="pc-header ">
        <div class="header-wrapper">
            <div class="ml-auto">
                <?php require_once 'user.search.inc.php'; ?>
            </div>
        </div>
    </header>

<section class="pc-container">
    <div class="pcoded-content">
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
                            <li class="breadcrumb-item">Registrar venta</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h5>Registrar Venta</h5>
                        <hr>
                        <?php require_once 'alertas.inc.php'; ?>
                        <div class="alert alert-info" role="alert">
                            <i data-feather="info"></i>
                            Agrega al menos un ticket
                        </div>
                        <form role="form" method="post">
                            <div class="row">
                                <div class="row">
                                    <div class="col-md-6">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <?php require_once 'vercolumnas.venta.inc.php'; ?>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php require_once 'listado.tipoTickets.ventas.inc.php'; ?>                                
                                            </tbody>
                                        </table>
                                        <span id="total">Total: $ 0.00</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <button class="btn btn-primary" type="submit" value="Registrar" name="BotonRegistrar" >Registrar</button>
                                        <a class="btn btn-light" href="index.php" role="button">Volver a Home</a>
                                        <input class="btn btn-secondary" type="reset" value="Limpiar datos" name="BotonLimpiar">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once 'footer.inc.php'; ?>
<?php require_once 'funciones/script.imprimir.inc.php'; ?>