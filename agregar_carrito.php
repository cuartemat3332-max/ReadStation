<?php
session_start();
include("CONFIG/Conexion.php");

if (!isset($_SESSION['id_usuario'])) {
    header("Location: LOGIN.HTML");
    exit;
}

$id_usuario = (int) $_SESSION['id_usuario'];
$id_libro = (int) $_POST['id_libro'];

$sql_precio = "SELECT PRECIO FROM LIBROS WHERE ID_LIBRO = $id_libro";
$resultado_precio = mysqli_query($conexion, $sql_precio);

if (mysqli_num_rows($resultado_precio) == 0) {
    header("Location: libros.php");
    exit;
}

$libro = mysqli_fetch_assoc($resultado_precio);
$precio = $libro['PRECIO'];

$sql_carrito = "SELECT ID_CARRITO FROM CARRITO WHERE ID_USUARIO = $id_usuario";
$resultado_carrito = mysqli_query($conexion, $sql_carrito);

if (mysqli_num_rows($resultado_carrito) > 0) {
    $fila = mysqli_fetch_assoc($resultado_carrito);
    $id_carrito = $fila['ID_CARRITO'];
} else {
    $sql_insertar = "INSERT INTO CARRITO (ID_USUARIO) VALUES ($id_usuario)";
    mysqli_query($conexion, $sql_insertar);
    $id_carrito = mysqli_insert_id($conexion);
}

$sql_detalle = "SELECT ID_LIBRO FROM DETALLE_CARRITO 
                WHERE ID_CARRITO = $id_carrito 
                AND ID_LIBRO = $id_libro";

$resultado_detalle = mysqli_query($conexion, $sql_detalle);

if (mysqli_num_rows($resultado_detalle) == 0) {
    $sql_agregar = "INSERT INTO DETALLE_CARRITO 
                    (ID_CARRITO, ID_LIBRO, PRECIO_UNITARIO) 
                    VALUES ($id_carrito, $id_libro, $precio)";

    mysqli_query($conexion, $sql_agregar);
    $_SESSION['abrir_carrito']=true;
    
}

header("Location: libros.php?id=" . $id_libro);
exit;
?>
