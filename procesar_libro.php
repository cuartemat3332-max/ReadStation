<?php
session_start();
include("CONFIG/Conexion.php");

if (!isset($_SESSION["id_usuario"])) {
    header("Location: LOGIN.HTML");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre          = mysqli_real_escape_string($conexion, $_POST["nombre"]);
    $descripcion     = mysqli_real_escape_string($conexion, $_POST["descripcion"]);
    $precio          = mysqli_real_escape_string($conexion, $_POST["precio"]);
    $isbn            = mysqli_real_escape_string($conexion, $_POST["isbn"]);
    $editorial       = mysqli_real_escape_string($conexion, $_POST["editorial"]);
    $id_autor        = mysqli_real_escape_string($conexion, $_POST["id_autor"]);
    $imagen          = mysqli_real_escape_string($conexion, $_POST["imagen"]);
    $archivo_libro   = mysqli_real_escape_string($conexion, $_POST["archivo_libro"]);

    $sql = "INSERT INTO LIBROS (NOMBRE, descripcion, precio, ISBN, imagen, ID_AUTOR, archivo_libro, EDITORIAL)          VALUES ('$nombre', '$descripcion', '$precio', '$isbn', '$imagen', '$id_autor', '$archivo_libro', '$editorial')";
    
    if (mysqli_query($conexion, $sql)) {
        header("Location: AUTH/INICIO_ADMIN.php");
        exit;
    } else {
        echo "Error al guardar el libro en la base de datos: " . mysqli_error($conexion);
    }

} else {
    header("Location: Agregar_libro.php");
    exit;
}
?>
