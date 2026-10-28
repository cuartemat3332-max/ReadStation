<?php
session_start();
include("../CONFIG/Conexion.php");
;
if ($_SERVER["REQUEST_METHOD"] != "POST") {
die("Método no permitido.");
}
$usuario = trim($_POST["usuario"] ?? "");
$password = $_POST["password"] ?? "";
if ($usuario == "" || $password == "") {
die("Debe completar todos los campos.");
}
$sql = "
SELECT id, nombre, password,rol
FROM usuarios
WHERE nombre = ?
";

$stmt = mysqli_prepare($conexion, $sql);
mysqli_stmt_bind_param(
$stmt,
"s",
$usuario
);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);
if ($fila = mysqli_fetch_assoc($resultado)) {
if (password_verify(
$password,
$fila["password"]
)) {
session_regenerate_id(true);
$_SESSION["id_usuario"] = $fila["id"];
$_SESSION["usuario"] = $fila["nombre"];
$_SESSION["rol"]=$fila["rol"];
header("Location: INICIO.php");
exit;
} else {
echo "<h2>Usuario o contraseña incorrectos</h2>";
}
} else {
echo "<h2>Usuario o contraseña incorrectos</h2>";
}
mysqli_stmt_close($stmt);
mysqli_close($conexion);
?>