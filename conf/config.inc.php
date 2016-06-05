<?php
/**
 * Conectamos a la base de datos
 */
$bd_host = "localhost";
$bd_nombre = "ejemplo";
$bd_usuario = "usuario";
$bd_password = "1234";

$conexion=@mysqli_connect($bd_host, $bd_usuario, $bd_password, $bd_nombre) or die ("No puedo conectar a el Servidor de Base de Datos");

include_once("lib/tpl.inc.php");


$tpl = new tpl("");
?>