<?php

//CLASES

class blog
{
	public $bd;

	function __construct()
	{

		//CONECTARSE A LA BASE DE DATOS

		$this->bd = new mysqli('localhost', 'root', '4ndr3s', 'blog-prueba');

		if($this->bd->connect_errno > 0) 
		{
			die('Imposible conectar [' . $this->bd->connect_error . ']');
		}



	}

	public function listar()
	{
		$sql = "SELECT posts.*, temas.nombre FROM posts LEFT JOIN temas ON posts.tema_id = temas.id order by posts.id desc";

		if (!$resultado = $this->bd->query($sql)) 
		{
			die ('Ocurrio un error ejecutando el query [' . $this->$bd->error .']');
		}
		return $resultado;

	}

	public function view($id=null)
	{
		$sql = "SELECT posts.*, temas.nombre FROM posts LEFT JOIN temas ON posts.tema_id = temas.id WHERE posts.id=$id";

		if (!$resultado = $this->bd->query($sql)) 
		{
			die ('Ocurrio un error ejecutando el query [' . $this->$bd->error .']');
		}
		return $resultado;

	}

	public function insertar($posts)
	{

		$sql = "INSERT INTO posts(titulo, subtitulo, texto, tema_id) VALUES ('".$posts['titulo']."','". $posts['subtitulo']."','".$posts['texto']."', '".$posts['tema_id']."')";

		if(! $this->bd->query($sql)){
		     die('Ocurrio un error ejecutando el query [' . $this->bd->error . ']');
		}
		header("Location: index.php");
	}

	public function modificar($post)
	{

		$sql = "UPDATE posts SET posts.titulo='{$post['titulo']}', posts.subtitulo = '{$post['subtitulo']}', posts.texto = '{$post['texto']}', posts.tema_id = '{$post['tema_id']}' WHERE posts.id={$post['id']} ";

		if(! $this->bd->query($sql)){
		     die('Ocurrio un error ejecutando el query [' . $this->bd->error . ']');
		}
		header("Location: view.php?id={$post['id']}"); 
	}

	public function eliminar($id)
	{
		$sql = "DELETE FROM posts WHERE id=$id";

		if(! $this->bd->query($sql)){
		     die('Ocurrio un error ejecutando el query [' . $this->bd->error . ']');
		}
		header("Location: index.php");
	}

	public function listarfecha($fecha)
	{
		$sql = "SELECT posts.*, temas.nombre FROM posts LEFT JOIN temas ON posts.tema_id = temas.id WHERE date_format(fecha, '%m-%Y') = '$fecha' ";

		$resultado = $this->bd->query($sql);
		if (!$resultado) 
		{
			die ('Ocurrio un error ejecutando el query [' . $this->$bd->error .']');
		}
		return $resultado;

	}

	public function formatFecha($old_fecha) 
	{
		$fecha = new DateTime($old_fecha);
		return $fecha->format('j/m/Y') ."&nbsp;&nbsp;&nbsp;". $fecha->format('H:i');
	}

	public function getmonths()
	{
		$sql = "SELECT fecha FROM posts order by fecha asc limit 1";

		if (!$resultado = $this->bd->query($sql)) 
		{
			die ('Ocurrio un error ejecutando el query [' . $this->$bd->error .']');
		}
		$menor = $resultado->fetch_assoc();
		$menor = $menor['fecha'];


		$sql2 = "SELECT fecha FROM posts order by fecha desc limit 1";
		if (!$resultado = $this->bd->query($sql2)) 
		{
			die ('Ocurrio un error ejecutando el query [' . $this->$bd->error .']');
		}
		$mayor = $resultado->fetch_assoc();
		$mayor = $mayor['fecha'];

		return array(
			'menor' => $menor,
			'mayor' => $mayor
		);
	}

	public function gettemas()
	{
		$sql = "SELECT * FROM temas order by nombre asc";
		if (!$resultado= $this->bd->query($sql)) 
		{
			die ('Ocurrio un error ejecutando el query ['. $this->$bd->error.']');
		}
		return $resultado;
	}

	public function listartema($tema_id)
	{
		$sql = "SELECT distinct posts.*, temas.nombre FROM posts INNER JOIN temas ON posts.tema_id=temas.id WHERE posts.tema_id= $tema_id ORDER BY posts.fecha DESC";

		if (!$resultado= $this->bd->query($sql)) 
		{
			die ('Ocurrio un error ejecutando el query ['. $this->$bd->error.']');
		}
		return $resultado;

	}

	/*public function login($usuario, $password)
	{
		if ($usuario == 'aaron' && $password == 'aaronesteban') 
		{
			session_start(oid)
		}
		else
		{
			echo "Usuario o contraseña incorrectos.";
		}
	
	}	 */
}