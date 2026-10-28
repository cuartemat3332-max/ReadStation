<?php
session_start();
include("CONFIG/Conexion.php");

if (!isset($_SESSION['id_usuario'])) {
    header("Location: LOGIN.HTML");
    exit;
}

if (isset($_POST['id_libro'])) {
    $id_usuario = (int) $_SESSION['id_usuario'];
    $id_libro = (int) $_POST['id_libro'];

    $sql_carrito = "SELECT ID_CARRITO FROM CARRITO WHERE ID_USUARIO = $id_usuario";
    $resultado_carrito = mysqli_query($conexion, $sql_carrito);
    
    if (mysqli_num_rows($resultado_carrito) > 0) {
        $fila = mysqli_fetch_assoc($resultado_carrito);
        $id_carrito = $fila['ID_CARRITO'];

        $sql_eliminar = "DELETE FROM DETALLE_CARRITO 
                         WHERE ID_CARRITO = $id_carrito 
                         AND ID_LIBRO = $id_libro";
        
        mysqli_query($conexion, $sql_eliminar);
    }

    $_SESSION['abrir_carrito'] = true;
    
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
}
?>
