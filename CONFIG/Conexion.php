<?php
$conexion = mysqli_connect(
"localhost",
"root",
"",
"readstation"
);
if (!$conexion) {
die("No se pudo conectar con la base de datos.");
}
mysqli_set_charset($conexion, "utf8mb4");
?>