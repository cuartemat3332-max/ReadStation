<?php
session_start();
include("CONFIG/Conexion.php");

if (!isset($_SESSION['id_usuario'])) {
    header("Location: LOGIN.HTML");
    exit;
}

$id_usuario = $_SESSION['id_usuario'];

if (isset($_POST['id_libro_directo'])) {
    $precio=(int)$_POST['total'];
    $id_libro = $_POST['id_libro_directo'];
    $insertar = "INSERT INTO compra(usuario_id, total) VALUES ('$id_usuario', '$precio')";
    mysqli_query($conexion, $insertar);
    
    $id_compra = mysqli_insert_id($conexion);
    
    $insertar_detalle = "INSERT INTO DETALLE_COMPRA(ID_COMPRA, ID_LIBRO, PRECIO_UNITARIO) VALUES ('$id_compra', '$id_libro', '$precio')";
    mysqli_query($conexion, $insertar_detalle);

} else {
    
    $insertar = "INSERT INTO compra (usuario_id, total) VALUES ('$id_usuario', '$precio')";
    mysqli_query($conexion, $insertar);

    $id_compra = mysqli_insert_id($conexion);

    $query_carrito = "SELECT DETALLE_CARRITO.ID_LIBRO, LIBROS.precio, CARRITO.ID_CARRITO  FROM DETALLE_CARRITO,LIBROS,CARRITO WHERE DETALLE_CARRITO.ID_LIBRO=LIBROS.ID_LIBRO AND CARRITO.ID_CARRITO=DETALLE_CARRITO.ID_CARRITO AND CARRITO.ID_USUARIO=USUARIOS.id AND USUARIOS.id='$id_usuario'";  

    $resultado_carrito = mysqli_query($conexion, $query_carrito);
    $id_carrito_a_vaciar = null;

    while ($fila = mysqli_fetch_assoc($resultado_carrito)) {
        $id_libro_car = $fila['ID_LIBRO'];
        $precio_unitario = $fila['precio'];
        $id_carrito_a_vaciar = $fila['ID_CARRITO']; 

        $insertar_detalle = "INSERT INTO DETALLE_COMPRA(ID_COMPRA, ID_LIBRO, PRECIO_UNITARIO) VALUES ('$id_compra', '$id_libro_car', '$precio_unitario')";
        mysqli_query($conexion, $insertar_detalle);
    }

    if ($id_carrito_a_vaciar) {
        $vaciar_carrito = "DELETE FROM DETALLE_CARRITO WHERE ID_CARRITO = '$id_carrito_a_vaciar'";
        mysqli_query($conexion, $vaciar_carrito);
    }
}

header("Location: MIS_LIBROS.PHP?status=success");
exit;
?>
