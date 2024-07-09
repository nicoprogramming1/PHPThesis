<?php
function ObtenerEventoPorId($conexion, $idEvento)
{
    // Sanitiza y verifica el ID de la recepcion para evitar SQL injection
    $idEvento = mysqli_real_escape_string($conexion, $idEvento);

    $evento = array();

    $sql = "SELECT idEvento, fechaEvento, detalleEvento FROM evento WHERE idEvento = $idEvento";

    $rs = mysqli_query($conexion, $sql);

    if ($rs) {
        $data = mysqli_fetch_array($rs);

        $evento['IDEVENTO'] = $data['idEvento'];
        $evento['DETALLEEVENTO'] = $data['detalleEvento'];
        $evento['FECHAEVENTO'] = $data['fechaEvento'];
    }

    return $evento;
}
?>