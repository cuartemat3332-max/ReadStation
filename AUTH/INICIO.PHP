<?php
session_start();
include("../CONFIG/Conexion.php");
if (!isset($_SESSION["id_usuario"])) {
    header("Location: LOGIN.HTML");
    exit;
}
if (isset($_SESSION["rol"]) && $_SESSION["rol"]=="admin") {
    header("Location: INICIO_ADMIN.PHP");
    exit;}
$id_usuario=$_SESSION["id_usuario"];
$sql="SELECT * FROM LIBROS WHERE LIBROS.ID_LIBRO NOT IN(SELECT LIBROS.ID_LIBRO FROM LIBROS,COMPRA,DETALLE_COMPRA,USUARIOS WHERE USUARIOS.id='$id_usuario' AND USUARIOS.id=COMPRA.usuario_id AND COMPRA.ID_COMPRA=DETALLE_COMPRA.ID_COMPRA AND DETALLE_COMPRA.ID_LIBRO=LIBROS.ID_LIBRO )";
$resultado= mysqli_query($conexion,$sql)
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>ReadStation</title>
    <link rel="stylesheet" href="../CSS/Catalogo.css">
    <link rel="stylesheet" href="../CSS/carrito.css">
</head>
<body>

<?php include("../carrito.php"); ?>

<header>
    <nav>
        <p>ReadStation</p>
        <img src="../UPLOAD/LOGOREADSTATION.jpeg" alt="LOGO">
        <a href="LOGOUT.PHP">Cerrar sesión</a>
        
        <label for="cart-toggle" class="boton-logo-carrito">
            <img src="../UPLOAD/LOGO.CARRITO.png" alt="Logo Carrito">
        </label>
        <a href="../MIS_LIBROS.PHP">MIS LIBROS</a>
    </nav>
</header>

<h1>Bienvenido</h1>

<div class="Barra">
<?php
while($fila=mysqli_fetch_assoc($resultado)){
    echo "<div class='Libro'>";
        echo '<span class="Imagen_Libro">';
        echo '    <img src="../UPLOAD/' . $fila["imagen"] . '" alt="Portada">';
        echo '</span>';
        echo "<span class='Nombre_Libro'>" . $fila['NOMBRE'] . "</span>";
        echo "<span class='Descipcion_Libro'>" . $fila['descripcion'] . "</span>";
        echo "<button>";
        echo '  <a href="../libros.php?id=' . $fila['ID_LIBRO'] . '">Comprar</a>';
        echo "</button>";
    echo "</div>";
}
?>
</div>

</body>
</html>
