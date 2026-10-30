<?php
session_start ();
include("CONFIG/Conexion.php");

if (!isset($_SESSION['id_usuario'])) {
    header("Location: LOGIN.HTML");
    exit;
};
$id_libro=$_GET['id'];
$abrir_carrito = false;
if (isset($_SESSION['abrir_carrito']) && $_SESSION['abrir_carrito'] === true) {
    $abrir_carrito = true;
    unset($_SESSION['abrir_carrito']); 
}

$sql="SELECT * FROM LIBROS WHERE ID_LIBRO='$id_libro'";

$resultado=mysqli_query($conexion,$sql);

if (mysqli_num_rows($resultado) > 0) {
        $libro = mysqli_fetch_assoc($resultado);
    } else {
        echo "No hay libros.";
        exit;
    }

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?php echo $libro['nombre']; ?></title>
    <link rel="stylesheet" href="CSS/Libro.css">
    <link rel="stylesheet" href="CSS/carrito.css">
</head>
<body>
    
    <?php include("carrito.php"); ?>
    <header>
    <nav>
        <a href="AUTH/INICIO.PHP" class="logo">
            <img src="UPLOAD/LOGOREADSTATION.jpeg" alt="ReadStation">
        </a>
        <div class="menu">
            <a href="AUTH/INICIO.PHP">Volver al Inicio</a>
            <label for="cart-toggle" class="boton-logo-carrito">
                <img src="UPLOAD/LOGO.CARRITO.png" alt="Carrito">
            </label>
        </div>
    </nav>
</header>
    <div class="contenedor-detalle">
        <div class="columna-izquierda">
            <img src="UPLOAD/<?php echo $libro['imagen']; ?>" alt="<?php echo $libro['NOMBRE']; ?>">
        </div>
        
        <div class="columna-derecha">
            <h1><?php echo $libro['NOMBRE']; ?></h1>
            <p class="autor"><strong>Autor:</strong> <?php echo $libro['ID_AUTOR']; ?></p>
            <p class="descripcion"><strong>Descripcion:</strong><?php echo $libro['descripcion']; ?></p>
            <p class="ISBN"><strong>ISBN:</strong> <?php echo $libro['ISBN']; ?></p>
            <p class="precio"><strong>Precio:</strong> $<?php echo $libro['precio']; ?></p>
            <p class="editorial"><strong>Editorial:</strong> <?php echo $libro['EDITORIAL']; ?></p>
            <a href=""></a>
            <form action="comprar_libros.php" method="POST">
                <input type="hidden" name="id_libro" value="<?php echo $libro['ID_LIBRO']; ?>">
                <button class="btn-comprar">Comprar Libro Digital</button>
            </form>
            <form action="agregar_carrito.php" method="POST">
                <input type="hidden" name="id_libro" value="<?php echo $libro['ID_LIBRO']; ?>">
            <button  type="submit" class="btn-añadirCarrito">Añadir al carrito</button>
            </form>
        </div>
    </div>
    
</body>
</html