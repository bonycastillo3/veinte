<?php
include ("conf/config.inc.php");
$vars="";
echo $tpl->cargar_parte('plt_datosAmigos.html','encabezado', $vars);

$consulta="SELECT * FROM amigos";
$resultado= mysqli_query($conexion, $consulta );
if (!$resultado)
{
	die("error de consulta");
}
else
{
	if(mysqli_num_rows($resultado)>0)
	{ 
		$amigos = mysqli_num_rows($resultado);
		for ($i=1; $i<=$amigos; $i++)
		{
			$fila = mysqli_fetch_array($resultado);
			$vars['nombre']= $fila['nombreAmigo'];
	$vars['edad']= $fila['edadAmigo'];
	$vars['telefono']= $fila['telefonoAmigo'];
	$vars['direccion']= $fila['direccionAmigo'];
	$vars['clave']= $fila['claveAmigo'];
			echo $tpl->cargar_parte('plt_datosAmigos.html','ficha',$vars);
		}
		}
		else
		{
			echo $tpl->cargar_parte('plt_datosAmigos.html','alone', $vars);
		}
} 
echo $tpl->cargar_parte('plt_datosAmigos.html','pie', $vars);
?>