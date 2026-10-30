<?php
session_start();
include("CONFIG/Conexion.php");
if (!isset($_SESSION['id_usuario'])) {
    header("Location: LOGIN.HTML");
    exit;
};

$id_usuario=$_SESSION['id_usuario'];
$libros_a_cobrar=[];
$total=0;
if(isset($_POST['id_libro'])){
    $id_libro=$_POST['id_libro'];
    $query="SELECT * FROM LIBROS WHERE ID_LIBRO='$id_libro'";
    $resultado=mysqli_query($conexion,$query);
    $libro=mysqli_fetch_assoc($resultado);
    if($libro){
        $libros_a_cobrar[]=$libro;
    }
}else{
    $query="SELECT LIBROS.* FROM LIBROS,DETALLE_CARRITO,CARRITO,USUARIOS WHERE USUARIOS.id='$id_usuario' AND USUARIOS.id=CARRITO.ID_USUARIO AND CARRITO.ID_CARRITO=DETALLE_CARRITO.ID_CARRITO AND DETALLE_CARRITO.ID_LIBRO=LIBROS.ID_LIBRO";
    $resultado=mysqli_query($conexion,$query);
    if($resultado->num_rows>0){
        while ($LIBRO = mysqli_fetch_assoc($resultado)) {
            $libros_a_cobrar[] = $LIBRO;
        }
    }else{
        header("Location: INDEX.PHP?error=carrito_vacio");
        exit;
    }
}

foreach ($libros_a_cobrar as $libro) {
    $total += $libro['precio']; 
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finalizar Compra</title>
    <link rel="stylesheet" href="CSS/Formularios.css">
</head>
<body>

<header>
    <nav>
        <a href="AUTH/INICIO.PHP" class="logo">
            <img src="UPLOAD/LOGOREADSTATION.jpeg" alt="ReadStation">
        </a>
        <a href="AUTH/INICIO.PHP">Volver al inicio</a>
    </nav>
</header>

<div class="contenedor-checkout">

    <div class="resumen-compra">
        <h3>Tu compra</h3>
        <ul>
            <?php foreach ($libros_a_cobrar as $libro): ?>
                <li>
                    <strong><?php echo $libro['NOMBRE']; ?></strong> - $<?php echo $libro['precio']; ?>
                </li>
            <?php endforeach; ?>
        </ul>
        <div class="total">
            <strong>Total a pagar: $<?php echo $total; ?></strong>
        </div>
    </div>

    <div class="formulario-pago">
        <h3>Datos de pago</h3>
        <form action="procesar_pago.php" method="POST">
            <input type="hidden" name="total" value="<?php echo $total; ?>">
            <?php if (isset($_POST['id_libro'])): ?>
                <input type="hidden" name="id_libro_directo" value="<?php echo $_POST['id_libro']; ?>">
            <?php endif; ?>

            <label>Nombre del titular:</label>
            <input type="text" name="titular" required placeholder="Juan Pérez">

            <label>Número de tarjeta:</label>
            <input type="text" name="tarjeta" required placeholder="4557 0000 0000 0000">

            <button type="submit">Confirmar compra</button>
        </form>
    </div>

</div>

</body>
</html>