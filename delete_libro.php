<?php
session_start();
include("CONFIG/Conexion.php");

if (!isset($_SESSION["id_usuario"])) {
    header("Location: LOGIN.HTML");
    exit;
}

if (isset($_GET["id_libro_eliminar"])) {
    
    $id_libro = mysqli_real_escape_string($conexion, $_GET["id_libro_eliminar"]);

    $sql = "DELETE FROM LIBROS WHERE ID_LIBRO='$id_libro'";
    $resultado = mysqli_query($conexion, $sql);

    if ($resultado) {
        header("Location: AUTH/INICIO_ADMIN.php"); 
        exit; 
    } else {
        echo "Error al eliminar el libro: " . mysqli_error($conexion);
    }
} else {
    echo "No se proporcionó ningún ID de libro.";
}
?>

