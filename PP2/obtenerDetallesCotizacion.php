<?php
require_once 'funciones/conexion.php';

$idCotizacion = $_GET['idCotizacion'];

$MiConexion = ConexionBD();
$detalleCotizacion = ObtenerCotizacionPorId($MiConexion, $idCotizacion);

// Devuelve los detalles en formato JSON
echo json_encode($detalleCotizacion);
?>