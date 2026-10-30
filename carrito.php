<?php 
include( $_SERVER['DOCUMENT_ROOT'] . '/READSTATION/CONFIG/Conexion.php' ); 

if (session_status() === PHP_SESSION_NONE) { 
    session_start(); 
} 

$id_usuario = $_SESSION['id_usuario']; 

$sql_cart = "SELECT LIBROS.imagen, LIBROS.NOMBRE, DETALLE_CARRITO.PRECIO_UNITARIO,DETALLE_CARRITO.ID_LIBRO FROM LIBROS, DETALLE_CARRITO, USUARIOS,CARRITO WHERE USUARIOS.id= '$id_usuario' AND USUARIOS.ID=CARRITO.ID_USUARIO AND DETALLE_CARRITO.ID_CARRITO=CARRITO.ID_CARRITO AND LIBROS.ID_LIBRO=DETALLE_CARRITO.ID_LIBRO"; 
$consulta = mysqli_query($conexion, $sql_cart); 
?> 

<input type="checkbox" id="cart-toggle" class="cart-toggle-checkbox" <?php echo (isset($abrir_carrito) && $abrir_carrito) ? 'checked' : ''; ?>> 
<label for="cart-toggle" class="cart-overlay"></label> 

<div class="card"> 
    <div class="header-card"> 
        <h2>Tu Carrito</h2> 
        <label for="cart-toggle" class="cart-close-btn">✕</label> 
    </div> 

    <div class="contenido-card"> 
        <?php 
        if (mysqli_num_rows($consulta) > 0) { 
            while($fila = mysqli_fetch_assoc($consulta)){ 
                echo '<div class="cart-item">'; 
                
                $ruta_imagen = (file_exists($_SERVER['DOCUMENT_ROOT'] . '/READSTATION/UPLOAD/' . $fila['imagen'])) ? '/READSTATION/UPLOAD/' . $fila['imagen'] : '../UPLOAD/' . $fila['imagen']; 
                
                echo '<img src="' . $ruta_imagen . '" alt="Portada" class="cart-item-img">'; 
                echo '<div class="cart-item-info">'; 
                echo '<span class="Nombre_Libro">' . $fila['NOMBRE'] . '</span>'; 
                echo '<span class="Descipcion_Libro">$' . $fila['PRECIO_UNITARIO'] . '</span>'; 
                echo '<form action="/READSTATION/eliminar_libro.php" method="POST" class="form-eliminar">'; 
                echo '<input type="hidden" name="id_libro" value="' . $fila['ID_LIBRO'] . '">'; 
                echo '<button type="submit" class="btn-eliminar-item">Eliminar</button>'; 
                echo '</form>'; 
                echo '</div>'; 
                echo '</div>'; 
            } 
            echo '<form action="/READSTATION/comprar_libros.php">'; 
            echo '<button class="btn-comprar">Comprar</button>' ;
            echo '</form>' ;
        } else { 
            echo '<p class="cart-empty">Tu carrito está vacío.</p>'; 
        } 
        ?> 
    
    </div> 
</div>
