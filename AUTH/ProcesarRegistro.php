<?php
include("../CONFIG/Conexion.php");

if ($_SERVER["REQUEST_METHOD"] != "POST") {
die("Método no permitido.");
}
$usuario = trim($_POST["usuario"] ?? "");
$email = trim($_POST["email"] ?? "");
$password = $_POST["password"] ?? "";


if (strlen($usuario) < 3 || strlen($usuario) > 30) {
die("El usuario debe tener entre 3 y 30 caracteres.");
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
die("El email ingresado no es válido.");
}
if (strlen($password) < 8) {
die("La contraseña debe tener al menos 8 caracteres.");
}
$passwordHash = password_hash(
$password,
PASSWORD_DEFAULT
);
$sql = "
INSERT INTO usuarios
(nombre, email, password)
VALUES (?, ?, ?)
";
$stmt = mysqli_prepare($conexion, $sql);
mysqli_stmt_bind_param(
$stmt,
"sss",
$usuario,
$email,
$passwordHash
);
if (mysqli_stmt_execute($stmt)) {
echo "<h2>Usuario registrado correctamente</h2>";
echo "<a href='LOGIN.HTML'>Iniciar sesión</a>";
} else {
echo "<h2>No se pudo registrar el usuario.</h2>";
echo "<p>El usuario o email podrían estar registrados.</p>";
}
mysqli_stmt_close($stmt);
mysqli_close($conexion);
?>