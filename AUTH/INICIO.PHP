<?php
session_start();
include("../CONFIG/Conexion.php");

if (!isset($_SESSION["id_usuario"])) {
    header("Location: LOGIN.HTML");
    exit;
}
if (isset($_SESSION["rol"]) && $_SESSION["rol"]=="admin") {
    header("Location: INICIO_ADMIN.PHP");
    exit;
}

$id_usuario = $_SESSION["id_usuario"];

$busqueda = "";
if (isset($_GET['busqueda']) && !empty(trim($_GET['busqueda']))) {
    $busqueda = mysqli_real_escape_string($conexion, $_GET['busqueda']);
}

$sql = "SELECT DISTINCT LIBROS.*,LIBROS.NOMBRE AS TITULO_LIBRO FROM LIBROS,AUTOR WHERE LIBROS.ID_LIBRO NOT IN(
            SELECT LIBROS.ID_LIBRO FROM LIBROS, COMPRA, DETALLE_COMPRA, USUARIOS,AUTOR
            WHERE USUARIOS.id='$id_usuario' 
            AND USUARIOS.id=COMPRA.usuario_id 
            AND COMPRA.ID_COMPRA=DETALLE_COMPRA.ID_COMPRA 
            AND DETALLE_COMPRA.ID_LIBRO=LIBROS.ID_LIBRO
            AND autor.ID_AUTOR=LIBROS.ID_AUTOR
        )";

if (!empty($busqueda)) {
    $sql .= " AND (LIBROS.NOMBRE LIKE '%$busqueda%' 
    OR AUTOR.NOMBRE LIKE '%$busqueda%')" ;
}

$resultado = mysqli_query($conexion, $sql);
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
        <a href="INICIO.PHP" class="logo">
            <img src="../UPLOAD/LOGOREADSTATION.jpeg" alt="ReadStation">
        </a>

        <form action="" method="GET" class="buscador">
            <input type="text" name="busqueda" value="<?php echo isset($_GET['busqueda']) ? htmlspecialchars($_GET['busqueda']) : ''; ?>" placeholder="Buscar libro o autor...">
            <button type="submit">Buscar</button>
            <?php if (!empty($busqueda)): ?>
                <a href="?" class="limpiar">Limpiar</a>
            <?php endif; ?>
        </form>

        <div class="menu">
            <a href="../MIS_LIBROS.PHP">Mis libros</a>
            <a href="LOGOUT.PHP">Cerrar sesión</a>
            <label for="cart-toggle" class="boton-logo-carrito">
                <img src="../UPLOAD/LOGO.CARRITO.png" alt="Carrito">
            </label>
        </div>
    </nav>
</header>

<h1>
    <?php 
    if (!empty($busqueda)) {
        echo "Resultados para: '" . htmlspecialchars($busqueda) . "'";
    } else {
        echo "Bienvenido";
    }
    ?>
</h1>

<div class="Barra">
<?php

if (mysqli_num_rows($resultado) > 0) {
    while($fila = mysqli_fetch_assoc($resultado)){
 echo "<div class='Libro'>";
    echo '<span class="Imagen_Libro">';
    echo '    <img src="../UPLOAD/' . $fila["imagen"] . '" alt="Portada">';
    echo '</span>';
    echo "<span class='Nombre_Libro'>" . $fila['TITULO_LIBRO'] . "</span>";
    echo "<span class='Descipcion_Libro'>" . $fila['descripcion'] . "</span>";
    echo '<a class="btn-comprar" href="../libros.php?id=' . $fila['ID_LIBRO'] . '">Comprar</a>';
echo "</div>";
    }
} else {
    echo "<p>No se encontraron libros.</p>";
}
?>
</div>

</body>
</html>
