<?php
$contador = 1;
foreach ($ListadoVentas as $venta) {
    echo '<tr>';
    echo '<td>' . $contador . '</td>';
    echo '<td>' . $venta['IDVENTA'] . '</td>';

    // buscamos el apellido del cajero por id
    $idCajero = $venta['IDCAJERO'];
    $cajero = ObtenerUsuarioPorID($MiConexion, $idCajero);
    $apellidoCajero = $cajero['APELLIDO'];
    echo '<td>' . $apellidoCajero . '</td>';
    echo '<td>' . $venta['FECHAVENTA'] . '</td>';
    echo '<td>' . $venta['HORAVENTA'] . '</td>';
    
    
    // buscamos el estado de la venta
    $idEstado = $venta['IDESTADO'];
    $estado = ObtenerEstadoVentaPorId($MiConexion, $idEstado);
    echo '<td>' . $estado . '</td>';

    echo '<td><button class="btn btn-danger" name="BotonCancelarVenta" value="' . $venta['IDVENTA'] . '">Cancelar Venta</button></td>';
    echo '</tr>';
    $contador++;
}
?>