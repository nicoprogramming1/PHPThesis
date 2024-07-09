<?php
$contador = 1;
foreach ($ListadoVentas as $venta) {
    echo '<tr>';
    echo '<td>' . $contador . '</td>';
    echo '<td>' . $venta['IDVENTA'] . '</td>';

    // buscamos el apellido del cajero por id
    $idCajero = $venta['IDCAJERO'];
    $apellidoCajero = ObtenerUsuarioPorID($MiConexion, $idCajero);
    echo '<td>' . $apellidoCajero . '</td>';
    
    echo '<td>' . $venta['FECHAVENTA'] . '</td>';
    echo '<td>' . $venta['HORAVENTA'] . '</td>';
    
    // buscamos el estado de la venta
    $idEstado = $venta['IDESTADO'];
    $estado = ObtenerEstadoVentaPorId($MiConexion, $idEstado);
    echo '<td>' . $estado . '</td>';
    
    
    // Reemplazamos el input checkbox por un input radio y le damos el mismo nombre para que formen un grupo
    echo '<td><input type="radio" name="seleccionar[' . $venta['IDVENTA'] . ']" value="' . $venta['IDVENTA'] . '"></td>';
    echo '</tr>';
    $contador++;
}
?>