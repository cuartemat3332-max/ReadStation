<?php
session_start();
include("CONFIG/Conexion.php");

if (!isset($_SESSION["id_usuario"])) {
    header("Location: LOGIN.HTML");
    exit;
}

$consulta_autores = mysqli_query($conexion, "SELECT ID_AUTOR, NOMBRE FROM AUTOR");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Nuevo Libro</title>
    <link rel="stylesheet" href="CSS/Catalogo.css">
</head>
<body>
    <h2>Agregar un Nuevo Libro</h2>
    
    <form action="procesar_libro.php" method="POST">
        
        <label for="nombre">Título / Nombre del Libro:</label><br>
        <input type="text" id="nombre" name="nombre" maxlength="150" required><br><br>

        <label for="descripcion">Descripción:</label><br>
        <textarea id="descripcion" name="descripcion"></textarea><br><br>

        <label for="precio">Precio ($):</label><br>
        <input type="number" id="precio" name="precio" step="0.01" required><br><br>

        <label for="isbn">ISBN:</label><br>
        <input type="text" id="isbn" name="isbn" maxlength="20"><br><br>

        <label for="editorial">Editorial:</label><br>
        <input type="text" id="editorial" name="editorial" maxlength="50"><br><br>

        <label for="id_autor">Autor:</label><br>
        <select id="id_autor" name="id_autor" required>
            <option value=""> Selecciona un Autor</option>
            <?php 
            while($autor = mysqli_fetch_assoc($consulta_autores)) {
                echo "<option value='".$autor['ID_AUTOR']."'>".$autor['NOMBRE']."</option>";
            }
            ?>
        </select><br><br>

        <label for="imagen">Nombre del archivo de imagen (ej: portada.jpg):</label><br>
        <input type="text" id="imagen" name="imagen" maxlength="255"><br><br>

        <label for="archivo_libro">Nombre del archivo del libro (ej: lectura.pdf):</label><br>
        <input type="text" id="archivo_libro" name="archivo_libro" maxlength="50" required><br><br>

        <button type="submit">Guardar Libro</button>
        <a href="AUTH/INICIO_ADMIN.php">Cancelar</a>
    </form>
</body>
</html>
