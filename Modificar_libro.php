<?php 
session_start(); 
include("CONFIG/Conexion.php"); 

if (!isset($_SESSION["id_usuario"])) { 
    header("Location: LOGIN.HTML"); 
    exit; 
} 

if (!isset($_GET["id_libro_editar"])) { 
    echo "No se especificó ningún libro para modificar."; 
    exit; 
} 

$id_libro = mysqli_real_escape_string($conexion, $_GET["id_libro_editar"]); 
$consulta_libro = mysqli_query($conexion, "SELECT * FROM LIBROS WHERE ID_LIBRO = '$id_libro'"); 
$libro = mysqli_fetch_assoc($consulta_libro); 

if (!$libro) { 
    echo "El libro especificado no existe."; 
    exit; 
} 

$consulta_autores = mysqli_query($conexion, "SELECT ID_AUTOR, NOMBRE FROM AUTOR"); 
?> 
<!DOCTYPE html> 
<html lang="es"> 
<head> 
    <meta charset="UTF-8"> 
    <title>Modificar Libro</title> 
    <link rel="stylesheet" href="CSS/Catalogo.css"> 
</head> 
<body> 
    <h2>Modificar Libro</h2> 
    <form action="procesar_modificacion.php" method="POST"> 
        <input type="hidden" name="id_libro" value="<?php echo $libro['ID_LIBRO']; ?>"> 
        
        <label for="nombre">Título / Nombre del Libro:</label><br> 
        <input type="text" id="nombre" name="nombre" maxlength="150" value="<?php echo $libro['NOMBRE']; ?>" required><br><br> 
        
        <label for="descripcion">Descripción:</label><br> 
        <textarea id="descripcion" name="descripcion"><?php echo $libro['descripcion']; ?></textarea><br><br> 
        
        <label for="precio">Precio ($):</label><br> 
        <input type="number" id="precio" name="precio" step="0.01" value="<?php echo $libro['precio']; ?>" required><br><br> 
        
        <label for="isbn">ISBN:</label><br> 
        <input type="text" id="isbn" name="isbn" maxlength="20" value="<?php echo $libro['ISBN']; ?>"><br><br> 
        
        <label for="editorial">Editorial:</label><br> 
        <input type="text" id="editorial" name="editorial" maxlength="50" value="<?php echo $libro['EDITORIAL']; ?>"><br><br> 
        
        <label for="id_autor">Autor:</label><br> 
        <select id="id_autor" name="id_autor" required> 
            <option value=""> Selecciona un Autor </option> 
            <?php 
            while($autor = mysqli_fetch_assoc($consulta_autores)) { 
                $selected = "";
                if ($autor['ID_AUTOR'] == $libro['ID_AUTOR']) {
                    $selected = "selected";
                }
                echo "<option value='".$autor['ID_AUTOR']."' $selected>".$autor['NOMBRE']."</option>"; 
            } 
            ?> 
        </select><br><br> 
        
        <label for="imagen">Nombre del archivo de imagen (ej: portada.jpg):</label><br> 
        <input type="text" id="imagen" name="imagen" maxlength="255" value="<?php echo $libro['imagen']; ?>"><br><br> 
        
        <label for="archivo_libro">Nombre del archivo del libro (ej: lectura.pdf):</label><br> 
        <input type="text" id="archivo_libro" name="archivo_libro" maxlength="50" value="<?php echo $libro['archivo_libro']; ?>" required><br><br> 
        
        <button type="submit">Guardar Cambios</button> 
        <a href="AUTH/INICIO_ADMIN.php">Cancelar</a> 
    </form> 
</body> 
</html>
