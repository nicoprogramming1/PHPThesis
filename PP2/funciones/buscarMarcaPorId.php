<?php
function ObtenerMarcaPorId($vConexion, $idMarca) {
    $Marca = array();

    // Sanitiza y verifica el ID de la marca para evitar SQL injection
    $idMarca = mysqli_real_escape_string($vConexion, $idMarca);

    // Consulta para obtener los detalles de la marca
    $SQL = "SELECT * from marca where idMarca = $idMarca";

    $rs = mysqli_query($vConexion, $SQL);

    if ($rs) {
        $data = mysqli_fetch_array($rs);

        $Marca['IDMARCA'] = $data['idMarca'];
        $Marca['MARCA'] = $data['marca'];
    }

    return $Marca;
}
?>