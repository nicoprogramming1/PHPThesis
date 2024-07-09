<?php
function InsertarMarca($MiConexion, $marca)
{
    $query = "INSERT INTO marca (marca) VALUES ('$marca')";

    $resultado = mysqli_query($MiConexion, $query);

    return $resultado;
}
?>