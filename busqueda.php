<?php
session_start();
include("CONFIG/Conexion.php");
if (!isset($_SESSION["id_usuario"])) {
    header("Location: LOGIN.HTML");
    exit;
}

$busqueda=$_GET['busqueda'];





