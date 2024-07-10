<?php

function ConexionBD($Host = 'mysql' ,  $User = 'root',  $Password = 'root', $BaseDeDatos='pp3' ) {

    $linkConexion = mysqli_connect($Host, $User, $Password, $BaseDeDatos);
    if ($linkConexion!=false) 
        return $linkConexion;
    else 
        die ('No se pudo establecer la conexión.');

}
?>
