
<?php
include ("conf/config.inc.php");
$consulta ="SELECT * FROM amigos";
$resultado = mysqli_query($conexion, $consulta);
if (!$resultado)
{
die("error en consulta");	
}
else
{
	if (mysqli_num_rows($resultado)>0)
	{	
	//$vars ['clave']="1";
	//$vars ['nombre']="ARNULFO";
	//$vars ['direccion']="Cholula privada #30";
	//$vars ['edad']="17";
	//$vars ['telefono']="2441135229";
	
	$fila= mysqli_fetch_array($resultado);
	$vars['nombre']= $fila['nombreCliente'];
	$vars['direccion']= $fila['direccion'];
	$vars['telefono']= $fila['telefonoCliente'];
	$vars['n.de cuenta']= $fila['cuenta'];
	echo $tpl->cargar('plt_datosAmigos.html' , $vars);
	
	$fila= mysqli_fetch_array($resultado);
	$vars['nombre']= $fila['nombreCliente'];
	$vars['direccion']= $fila['direccion'];
	$vars['telefono']= $fila['telefonoCliente'];
	$vars['n.de cuenta']= $fila['cuenta'];
	echo $tpl->cargar('plt_datosAmigos.html' , $vars);
	
	
	$fila= mysqli_fetch_array($resultado);
	$vars['nombre']= $fila['nombreCliente'];
	$vars['direccion']= $fila['direccion'];
	$vars['telefono']= $fila['telefonoCliente'];
	$vars['n.de cuenta']= $fila['cuenta'];
	echo $tpl->cargar('plt_datosAmigos.html' , $vars);
	}
	else
	{
	echo ("no hay amigos");
	}
//echo mysqli_num_rows($resultado);	
}

?>