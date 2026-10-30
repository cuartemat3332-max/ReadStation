<?php
session_start();
include("CONFIG/Conexion.php");

if (!isset($_SESSION["id_usuario"])) {
    header("Location: LOGIN.HTML");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_libro        = mysqli_real_escape_string($conexion, $_POST["id_libro"]);
    $nombre          = mysqli_real_escape_string($conexion, $_POST["nombre"]);
    $descripcion     = mysqli_real_escape_string($conexion, $_POST["descripcion"]);
    $precio          = mysqli_real_escape_string($conexion, $_POST["precio"]);
    $isbn            = mysqli_real_escape_string($conexion, $_POST["isbn"]);
    $editorial       = mysqli_real_escape_string($conexion, $_POST["editorial"]);
    $id_autor        = mysqli_real_escape_string($conexion, $_POST["id_autor"]);
    $imagen          = mysqli_real_escape_string($conexion, $_POST["imagen"]);
    $archivo_libro   = mysqli_real_escape_string($conexion, $_POST["archivo_libro"]);

    $sql = "UPDATE LIBROS SET 
                NOMBRE = '$nombre', 
                descripcion = '$descripcion', 
                precio = '$precio', 
                ISBN = '$isbn', 
                imagen = '$imagen', 
                ID_AUTOR = '$id_autor', 
                archivo_libro = '$archivo_libro', 
                EDITORIAL = '$editorial' 
            WHERE ID_LIBRO = '$id_libro'";
    
    if (mysqli_query($conexion, $sql)) {
        header("Location: AUTH/INICIO_ADMIN.php");
        exit;
    } else {
        echo "Error al actualizar el libro: " . mysqli_error($conexion);
    }

} else {
    header("Location: AUTH/INICIO_ADMIN.php");
    exit;
}
?>
