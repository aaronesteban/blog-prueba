<?php

session_start();

//CLASES
class blog
{
	public $bd;

	public $rutaabsoluta = 'C:\xampp/htdocs/blog/img/';
	public $rutaweb = 'img/';


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
		$sql = "SELECT posts.*, temas.nombre, imagenes.nombre_img, imagenes.ruta FROM posts LEFT JOIN temas ON posts.tema_id = temas.id LEFT JOIN imagenes ON posts.imagen_id = imagenes.id order by posts.id desc";

		if (!$resultado = $this->bd->query($sql)) 
		{
			die ('Ocurrio un error ejecutando el query [' . $this->$bd->error .']');
		}
		return $resultado;

	}

	public function view($id=null)
	{
		$sql = "SELECT posts.*, temas.nombre, imagenes.nombre_img, imagenes.ruta FROM posts LEFT JOIN temas ON posts.tema_id = temas.id LEFT JOIN imagenes ON posts.imagen_id = imagenes.id WHERE posts.id=$id";

		if (!$resultado = $this->bd->query($sql)) 
		{
			die ('Ocurrio un error ejecutando el query [' . $this->$bd->error .']');
		}
		return $resultado;

	}

	public function insertar($posts,$rutaweb=null,$nombre=null)
	{

		if (!empty($nombre) && !empty($rutaweb)) {
			$sql2 = "INSERT INTO imagenes(nombre_img, ruta) VALUES ('$nombre', '$rutaweb')";
	 		$this->bd->query($sql2);
	 		$imagen_id = $this->bd->insert_id;

			$sql = "INSERT INTO posts(titulo, subtitulo, texto, tema_id, imagen_id) VALUES ('".$posts['titulo']."','". $posts['subtitulo']."','".$posts['texto']."', ".$posts['tema_id'].", $imagen_id)";
			if(! $this->bd->query($sql)){
			     die('Ocurrio un error ejecutando el query [' . $this->bd->error . ']');
			}
		}
		else
		{
			$sql = "INSERT INTO posts(titulo, subtitulo, texto, tema_id) VALUES ('".$posts['titulo']."','". $posts['subtitulo']."','".$posts['texto']."', ".$posts['tema_id'].")";
			
			if(! $this->bd->query($sql)){
				die('Ocurrio un error ejecutando el query [' . $this->bd->error . ']');
			}
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
		
		$sql = "SELECT imagenes.nombre_img FROM `posts` LEFT JOIN imagenes On posts.imagen_id=imagenes.id WHERE posts.id=$id";
		$resultado = $this->bd->query($sql);
		$nombre_img = $resultado->fetch_row();

		if (!empty($nombre_img[0])) {
			@unlink($this->rutaabsoluta.$nombre_img[0]);
		}

		$sql = "DELETE posts.*, imagenes.* FROM posts LEFT JOIN imagenes ON posts.imagen_id = imagenes.id WHERE posts.id=$id";

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

	public function busqueda($busqueda)
	{
		$sql = "SELECT posts.*, temas.nombre FROM posts LEFT JOIN temas ON posts.tema_id = temas.id WHERE texto LIKE '%$busqueda%' OR titulo LIKE '%$busqueda%' OR subtitulo LIKE '%$busqueda%' ORDER BY fecha DESC LIMIT 50";

		if (!$resultado= $this->bd->query($sql)) 
		{
			die ('Ocurrio un error ejecutando el query ['. $this->bd->error.']');
		}
		return $resultado;

	}

	public function login($usuario, $password)
	{
		$sql = "SELECT * FROM users WHERE users.user = '$usuario' && users.password = '$password'";

		if (!$resultado= $this->bd->query($sql)) 
		{
			die ('Ocurrio un error ejecutando el query ['. $this->bd->error.']');
		}

		if ($resultado->num_rows === 1) 
		{
			$user = $resultado->fetch_row();
			$_SESSION['login'] = $user[3];
			header("Location: index.php");
			if ($usuario == 'aaron' && $password == 'aaronesteban') {
				$_SESSION['login'] = $user[1];
			}
		}
		else
		{
			unset($_SESSION['login']);
			$_SESSION['msg'] = "Usuario o contraseña incorrectos.";
		}
	
	}

	public function logout()
	{

		unset($_SESSION['login']);
		header("Location: index.php");
	}

	public function isloged()
	{
		if (isset($_SESSION['login'])){
			return true;
		}
		else
		{
			return false;
		}
	
	}

	public function registrarse($registro)
	{

		if ($registro['password'] !== $registro['password1']) {
			$_SESSION['msg'] = "Las contraseñas no coinciden.";
		}
		else
		{
			$sql = "INSERT INTO users(nombre, user, password) VALUES ('".$registro['nombre']."','". $registro['usuario']."','".$registro['password']."')";

			if(!$this->bd->query($sql)){
			     die('Ocurrio un error ejecutando el query [' . $this->bd->error . ']');
			}
			header("Location: index.php");
		}
	}
}