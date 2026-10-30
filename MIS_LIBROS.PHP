<?php
session_start();
include("CONFIG/Conexion.php");
if (!isset($_SESSION["id_usuario"])) {
    header("Location: LOGIN.HTML");
    exit;
} 
if (isset($_GET['status']) && $_GET['status'] === 'success') {
    echo '<div style="background-color: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin: 20px 0; text-align: center; font-family: sans-serif;">';
    echo '  <strong>¡Compra realizada con éxito!</strong> Tus archivos digitales ya están listos para descargar.';
    echo '</div>';
}
$id_usuario=$_SESSION['id_usuario'];
$sql="SELECT LIBROS.* FROM LIBROS,COMPRA,DETALLE_COMPRA,USUARIOS WHERE USUARIOS.id='$id_usuario' AND COMPRA.usuario_id=USUARIOS.id AND DETALLE_COMPRA.ID_COMPRA=COMPRA.id_COMPRA AND DETALLE_COMPRA.ID_LIBRO=LIBROS.ID_LIBRO";

$resultado=mysqli_query($conexion,$sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/Catalogo.css">
    <link rel="stylesheet" href="CSS/carrito.css">
    <title>Mis libros</title>
</head>
<body>
    <?php include("carrito.php"); ?>

<header>
    <nav>
        <a href="AUTH/INICIO.PHP" class="logo">
            <img src="UPLOAD/LOGOREADSTATION.jpeg" alt="ReadStation">
        </a>

        <div class="menu">
            <a href="AUTH/INICIO.PHP">Ir al inicio</a>
            <a href="AUTH/LOGOUT.PHP">Cerrar sesión</a>
            <label for="cart-toggle" class="boton-logo-carrito">
                <img src="UPLOAD/LOGO.CARRITO.png" alt="Carrito">
            </label>
        </div>
    </nav>
</header>

<h1>Mis libros</h1>

<div class="Barra">
<?php
while ($fila = mysqli_fetch_assoc($resultado)) {
    echo "<div class='Libro'>";
        echo '<span class="Imagen_Libro">';
        echo '    <img src="UPLOAD/' . $fila["imagen"] . '" alt="Portada">';
        echo '</span>';
        echo "<span class='Nombre_Libro'>" . $fila['NOMBRE'] . "</span>";
        echo "<span class='Descipcion_Libro'>" . $fila['descripcion'] . "</span>";
        echo '<a class="btn-leer" href="LEER_LIBRO.php?ruta_libro_abrir=UPLOAD/' . $fila['archivo_libro'] . '" target="_blank">Leer libro</a>';
    echo "</div>";
}
?>
</div>

</body>
</html>