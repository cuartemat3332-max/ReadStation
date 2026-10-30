<?php
session_start();
include("CONFIG/Conexion.php");

if (!isset($_SESSION['id_usuario'])) {
    header("Location: LOGIN.HTML");
    exit;
}



$id_usuario = $_SESSION['id_usuario'];
$archivo = $_GET['ruta_libro_abrir'];

if (file_exists($archivo)) {
    header('Content-Type: application/pdf');
    header('Content-Disposition: inline; filename="' . basename($archivo) . '"');
    header('Content-Transfer-Encoding: binary');
    header('Accept-Ranges: bytes');
    
    readfile($archivo);
    exit;
} else {
    echo "El archivo PDF no existe.";
}
?>

