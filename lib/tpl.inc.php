<?php
class tpl{

	/*
	 * Variables Privadas
	 */
	var $base;
	var $archivo;
	var $contenido;
	var $variables = array();
	var $var_ini = "{";
	var $var_fin = "}";
	var $par_ini = "<!--{";
	var $par_fin = "}-->";
	var $msg_error = "si"; 			// "si" | "no" | "halt"
	var $sin_valor = "borrar"; 	// "borrar" | "marcar" | "mantener"

	/*
	 * void tpl([string $base]);
	 * -------------------------
	 * Constructor.
	 * Asigna el directorio base de las plantillas.
	 */
	function tpl($base = "./"){
		$this->base = $base;
	}

	/*
	 * void asignar_base([string $base]);
	 * ----------------------------------
	 * Asigna el directorio base de las plantillas.
	 */
	function asignar_base($base = "./"){
		$this->base = $base;
	}

	/*
	 * void asignar_tags([string $inicio], [string $final]);
	 * -----------------------------------------------------
	 * Asigna los caracteres que encierran las variables en las Plantillas.
	 */
	function asignar_tags($inicio = "{", $final = "}"){
		$this->var_ini = $inicio;
		$this->var_fin = $final;
	}

	/*
	 * void asignar_partes([string $inicio], [string $final]);
	 * -------------------------------------------------------
	 * Asigna los caracteres que encierran las partes en las Plantillas.
	 */
	function asignar_partes($inicio = "<!--{", $final = "}-->"){
		$this->par_ini = $inicio;
		$this->par_fin = $final;
	}

	/* 
	 * void asignar_error([string $msg_error]);
	 * ----------------------------------------
	 * Asigna el estado de manejo de errores con los siguientes valores:
	 * "no" - No reporta los errores encontrados
	 * "si" - Reporta los errores encontrados
	 * "halt" - Reporta el primer error y detiene la ejecucion
	 */
	function asignar_error($msg_error = ""){
		if ($msg_error == "si"){
			$this->msg_error = $msg_error;
		}
		elseif ($msg_error == "halt"){
			$this->msg_error = $msg_error;
		}
		else {
			$this->msg_error = "no";
		}
	}

	/*
	 * void asignar_sin_valor([string $sin_valor]);
	 * --------------------------------------------
	 * Asigna el estado de manejo de variables no definidas en la Plantilla
	 * con los siguintes valores:
	 * "borrar" - Borra todas la variables no definidas
	 * "marcar" - Resalta las Variables no definidas
	 * "mantener" - No hace nada con las Variables no definidas
	 */
	function asignar_sin_valor($sin_valor = ""){
		if ($sin_valor == "marcar"){
			$this->sin_valor = $sin_valor;
		}
		elseif ($sin_valor == "borrar"){
			$this->sin_valor = $sin_valor;
		}
		else {
			$this->sin_valor = "mantener";
		}
	}

	/*
	 * void nuevo();
	 * -------------
	 * Borra todas las variables definidas anteriormente.
	 */
	function nuevo(){
		$this->archivo = '';
		$this->contenido = '';
		foreach ($this->variables as $elemento){
  			unset($elemento);
		}
	}

	/*
	 * string abrir(string $archivo);
	 * ------------------------------
	 * Abre el archivo especificado en '$archivo'.
	 */
	function abrir($archivo){
		$this->archivo = $this->base . $archivo;
		if (file_exists($this->archivo)){
			if ($fp = fopen($this->archivo, 'r')){
				$this->contenido = fread($fp, filesize($this->archivo));
				fclose($fp);
				return $this->contenido;
			}
			$this->debug("Plantilla no legible ($this->archivo)");
			return false;
		}
		$this->debug("Plantilla Inexistente ($this->archivo)");
		return false;
	}

	/*
	 * string extraer_parte(string $parte);
	 * ------------------------------------
	 * Funcion encargada de extraer el texto econtrado entre los separadores
	 * de partes.
	 */
	function extraer_parte($part){
		$this->parte = $part;
/*		$cadena = 'foobar: 2008';

preg_match('/(?P<nombre>\w+): (?P<dígito>\d+)/', $cadena, $coincidencias);*/

/* Esto también funciona en PHP 5.2.2 (PCRE 7.0) y posteriores, sin embargo
 * la forma de arriba es la recomendada por compatibilidad con versiones anteriores */
// preg_match_all('/(?<nombre>\w+): (?<dígito>\d+)/', $cadena, $coincidencias);

//print_r($coincidencias);
//print_r($this->par_ini . '/' . $parte . $this->par_fin);
//$compara = '#\<!--{pie}--\>' . '(.*\n*)' . '\/pie}--\>#';
//$cadena_1 = 'contenido:.:'.$this->contenido.':.:contenido';
//print_r (preg_match($compara,$cadena_1,$consulta));

//print_r($consulta);
//return false;

	if (!empty($this->parte) && preg_match('#'.$this->par_ini . $this->parte . $this->par_fin . '(.*)' . $this->par_ini . '\/' . $this->parte . $this->par_fin.'#sm', $this->contenido, $resultado)){
//			print_r($resultado);
			$this->contenido = $resultado[1];
			return $this->contenido;
		}
		$this->contenido = '';
		$this->debug("No se encontró parte {$this->parte}");
		return false;
	}

	/*
	 * string extraer_sin_parte(string $parte);
	 * ----------------------------------------
	 * Funcion encargada de extraer el texto econtrado entre los separadores
	 * de partes.
	 */
	function extraer_sin_parte($part){
		$this->parte = $part;
		if (!empty($this->parte) && preg_match ('#(.*)' . $this->par_ini . $this->parte . $this->par_fin . '(.*)' . $this->par_ini . '\/' . $this->parte . $this->par_fin . '(.*)#sm', $this->contenido, $resultado)){
			$this->contenido = $resultado[1] . $resultado[3];
			return $this->contenido;
		}
		$this->contenido = '';
		$this->debug("No se encontró parte {$this->parte}");
		return false;
	}

	/*
	 * bool agregar_vars(mixed $nombre, [string $valor]);
	 * --------------------------------------------------
	 * Esta funcion agrega ya sea, un array al array de variables interna,
	 * o se puede pasar uno a uno los valores que se agregaran a el array
	 * de variables interna '$variables'.
	 */
	function agregar_vars($nombre, $valor = ""){
		if (is_array($nombre)){
			$this->variables = $nombre;
			return true;
		}
		elseif ($nombre != "" && $valor != ""){
			$this->variables[$nombre] = $valor;
			return true;
		}
		else {
			$this->debug("No se han podido asignar las variables");
			return false;
		}
	}

	/*
	 * string parser();
	 * ----------------
	 * Reemplaza y devuelve las variables de '$contenido'.
	 */
	function parser(){
		if ($this->contenido != ''){
			while (list($nombre, $valor) = each($this->variables)){
				$this->contenido = str_replace($this->var_ini.$nombre.$this->var_fin, $valor, $this->contenido);
			}
			if ($this->sin_valor == "borrar"){
				$this->contenido = preg_replace('/'.$this->par_ini.'(\w+)'.$this->par_fin.'/', "", $this->contenido);
				$this->contenido = preg_replace('/'.$this->par_ini.'\/(\w+)'.$this->par_fin.'/', "", $this->contenido);
				$this->contenido = preg_replace('/'.$this->var_ini.'(\w+)'.$this->var_fin.'/', "", $this->contenido);
			}
			elseif ($this->sin_valor == "marcar"){
				$this->contenido = preg_replace('/'.$this->par_ini.'(\w+)'.$this->par_fin.'/', "<b>Principio de Parte:</b> \\1", $this->contenido);
				$this->contenido = preg_replace('/'.$this->par_ini.'\/(\w+)'.$this->par_fin.'/', "<b>Final de Parte:</b> \\1", $this->contenido);
				$this->contenido = preg_replace('/'.$this->var_ini.'(\w+)'.$this->var_fin.'/', "<b>Sin definir:</b> \\1", $this->contenido);
			}
			return $this->contenido;
		}
		$this->debug("No hay ninguna Platilla abierta");
		return false;
	}

	/*
	 * string cargar(string $archivo, [array $vars]);
	 * ----------------------------------------------
	 * Funcion que devuelve el contenido completo de la plantilla '$archivo'
	 * con sus variables reemplazadas de '$vars'
	 */
	function cargar($archivo, $vars=""){
		$this->nuevo();
		$this->abrir($archivo);
		(!empty($vars)) ? $this->agregar_vars($vars): '';
		$this->parser();
		return $this->contenido;
	}

	/*
	 * string cargar_parte(string $archivo, string $parte, [array $vars]);
	 * -------------------------------------------------------------------
	 * Funcion que devuelve el contenido de la plantilla '$archivo' encerrado 
	 * entre separadores de parte de nombre '$parte' y con sus variables
	 * reemplazadas de '$vars'
	 */
	function cargar_parte($archivo, $parte, $vars=""){
		$this->nuevo();
		$this->abrir($archivo);
		$this->extraer_parte($parte);
		(!empty($vars)) ? $this->agregar_vars($vars): '';
		$this->parser();
		return $this->contenido;
	}
	 
	/*
	 * string cargar_sin_parte(string $archivo, string $parte, [array $vars]);
	 * -----------------------------------------------------------------------
	 * Funcion que devuelve el contenido de la plantilla '$archivo' sin incluir
	 * el contenido que se encuentra entre los separadores de parte de nombre
	 * '$parte' y con sus variables reemplazadas de '$vars'
	 */
	function cargar_sin_parte($archivo, $parte, $vars=""){
		$this->nuevo();
		$this->abrir($archivo);
		$this->extraer_sin_parte($parte);
		(!empty($vars)) ? $this->agregar_vars($vars): '';
		$this->parser();
		return $this->contenido;
	}

	/*
	 * string cagar_js($js);
	 * -----------------------------------------------------------------------
	 * Funcion para cargar archivos externos de javascript, de la forma:
	 * <script language='javascript' src='archivo.js'></script>
	 * donde '$js' es el archivo llamado.
	 */
	function cargar_js($js){
		$this->js = $this->base . $js;
	 	if (file_exists($this->js)){
	 		$script = "<script language='JavaScript' src='$js'></script>";
			return $script;
	 	}
		$this->debug("Archivo JavaScript ($js) no Encontrado.");
		return false;
	 }
	
	/*
	 * void debug(string $msg);
	 * ------------------------
	 * Funcion para el manejo de errores de la clase.
	 */
	function debug($msg){
		if ($this->msg_error == "si"){
			echo "<br><b>Error:</b> " . $msg . "<br>";
		}
		elseif ($this->msg_error == "halt"){
			die ("<br><b>Error:</b> " . $msg . "<br>");
		}
		return false;
	}
}

?>
