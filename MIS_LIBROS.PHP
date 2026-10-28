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
        <p>ReadStation</p>
        <img src="UPLOAD/LOGOREADSTATION.jpeg" alt="LOGO">
        <a href="AUTH/LOGOUT.PHP">Cerrar sesión</a>
        
        <label for="cart-toggle" class="boton-logo-carrito">
            <img src="UPLOAD/LOGO.CARRITO.png" alt="Logo Carrito">
        </label>
        <a href="AUTH/INICIO.PHP">IR AL INICIO</a>
    </nav>
</header>

<h1>Bienvenido</h1>

<div class="Barra">
<?php
while($fila=mysqli_fetch_assoc($resultado)){
    echo "<div class='Libro'>";
        echo '<span class="Imagen_Libro">';
        echo '    <img src="UPLOAD/' . $fila["imagen"] . '" alt="Portada">';
        echo '</span>';
        echo "<span class='Nombre_Libro'>" . $fila['NOMBRE'] . "</span>";
        echo "<span class='Descipcion_Libro'>" . $fila['descripcion'] . "</span>";
        echo "<button>";
        echo '  <a href="../LEER_LIBRO.php?id=' . $fila['ID_LIBRO'] . '">VER LIBRO</a>';
        echo "</button>";
    echo "</div>";
}
?>
</div>

</body>
</html>
    
</body>
</html>