<?php
session_start();
include('../CONFIG/Conexion.php');

if (!isset($_SESSION['id_usuario'])) {
    header("Location: LOGIN.HTML");
    exit;
}

$sql = "SELECT * FROM LIBROS";
$resultado = mysqli_query($conexion, $sql); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/Catalogo.css">
    <title>Inicio Admin</title>
</head>
<body>
    <header>
        <nav>
            <a href="../Agregar_libro.php">Agregar Libro</a>
        </nav>
    </header>
    <div class="Barra">
        <?php 
        if ($resultado && mysqli_num_rows($resultado) > 0) {
            while ($fila = mysqli_fetch_assoc($resultado)) {
                echo '<div class="Libro">';
                echo '<span class="Imagen_Libro">';
                echo '<img src="../UPLOAD/' . $fila['imagen'] . '" alt="Portada">';
                echo '</span>';
                echo '<span class="Nombre_Libro">' . $fila['NOMBRE'] . '</span>';
                echo '<span class="Descipcion_Libro">' . $fila['descripcion'] . '</span>';
                echo '<button>';
                echo '<a href="../delete_libro.php?id_libro_eliminar=' . $fila['ID_LIBRO'] . '">ELIMINAR</a>';
                echo '</button>';
                echo '<button>';
                echo '<a href="../Modificar_libro.php?id_libro_editar=' . $fila['ID_LIBRO'] . '">MODIFICAR</a>';
                echo '</button>';
                echo '</div>';
            }
        }
        ?>
    </div>
</body>
</html>
