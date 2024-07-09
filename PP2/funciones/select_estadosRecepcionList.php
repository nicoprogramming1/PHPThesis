<?php
function ObtenerListaEstadosRecepcion($conexion) {
    $ListadoEstados = array();

    $SQL = "SELECT estadoRecepcion, idEstadoRecepcion FROM estado_recepcion WHERE idEstadoRecepcion != 2";

    $resultado = mysqli_query($conexion, $SQL);

    $i = 0;
    while ($data = mysqli_fetch_array($resultado)) {
        $ListadoEstados[$i]['IDESTADORECEPCION'] = $data['idEstadoRecepcion'];
        $ListadoEstados[$i]['ESTADORECEPCION'] = $data['estadoRecepcion'];
        $i++;
    }
    return $ListadoEstados;
}
?>