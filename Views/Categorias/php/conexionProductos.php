<?php
$conexion = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
if ($conexion->connect_error) {
    die("No se pudo Realizar la conexion");
}

?>