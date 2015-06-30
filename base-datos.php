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
		$sql = "SELECT posts.*, temas.nombre, imagenes.nombre_img, imagenes.ruta, videos.ruta_video, videos.ruta_vimeo FROM posts LEFT JOIN temas ON posts.tema_id = temas.id LEFT JOIN imagenes ON posts.imagen_id = imagenes.id LEFT JOIN videos ON posts.video_id = videos.id order by posts.id desc";

		if (!$resultado = $this->bd->query($sql)) 
		{
			die ('Ocurrio un error ejecutando el query [' . $this->$bd->error .']');
		}
		return $resultado;

	}

	public function view($id=null)
	{
		$sql = "SELECT posts.*, temas.nombre, imagenes.nombre_img, imagenes.ruta, videos.ruta_video, videos.ruta_vimeo FROM posts LEFT JOIN temas ON posts.tema_id = temas.id LEFT JOIN imagenes ON posts.imagen_id = imagenes.id LEFT JOIN videos ON posts.video_id = videos.id WHERE posts.id=$id";

		if (!$resultado = $this->bd->query($sql)) 
		{
			die ('Ocurrio un error ejecutando el query [' . $this->$bd->error .']');
		}
		return $resultado;

	}

	public function insertar($posts, $imagen_id, $video_id, $video_vimeo)
	{
		$user_id = $_SESSION['user'];


 		if (!empty($video_id) && !empty($imagen_id)) 
 		{
			$sql = "INSERT INTO posts(titulo, subtitulo, texto, tema_id, imagen_id, user_id, video_id) VALUES ('".$posts['titulo']."','". $posts['subtitulo']."','".$posts['texto']."', ".$posts['tema_id'].", $imagen_id, $user_id, $video_id)";
			if(! $this->bd->query($sql)){
			     die('Ocurrio un error ejecutando el query [' . $this->bd->error . ']');
 			}
 		}
 		elseif (!empty($video_id) && empty($imagen_id)) 
 		{
			$sql = "INSERT INTO posts(titulo, subtitulo, texto, tema_id, user_id, video_id) VALUES ('".$posts['titulo']."','". $posts['subtitulo']."','".$posts['texto']."', ".$posts['tema_id'].", $user_id, $video_id)";
			if(! $this->bd->query($sql)){
			     die('Ocurrio un error ejecutando el query [' . $this->bd->error . ']');
			}
 		}
 		elseif (empty($video_id) && !empty($imagen_id)) 
 		{
			$sql = "INSERT INTO posts(titulo, subtitulo, texto, tema_id, imagen_id, user_id) VALUES ('".$posts['titulo']."','". $posts['subtitulo']."','".$posts['texto']."', ".$posts['tema_id'].", $imagen_id, $user_id)";
			if(! $this->bd->query($sql)){
			     die('Ocurrio un error ejecutando el query [' . $this->bd->error . ']');
			}
 		}
 		elseif (empty($video_id) && empty($imagen_id)) 
 		{
			$sql = "INSERT INTO posts(titulo, subtitulo, texto, tema_id, user_id) VALUES ('".$posts['titulo']."','". $posts['subtitulo']."','".$posts['texto']."', ".$posts['tema_id'].", $user_id)";
			if(! $this->bd->query($sql)){
			     die('Ocurrio un error ejecutando el query [' . $this->bd->error . ']');
			}
 		}
		
		header("Location: index.php");
	}

	public function insertar_imagen($rutaweb=null,$nombre=null)
	{

		$imagen_id = NULL;

		if (!empty($nombre) && !empty($rutaweb)) 
		{
			$sql = "SELECT imagenes.nombre_img FROM `imagenes` WHERE imagenes.nombre_img = '$nombre'";
			$resultado = $this->bd->query($sql);
			
			$resultado->num_rows === 1;
			$existe = $resultado->fetch_row();
			$existe = $existe[0];
			$nombre_img = $nombre;
			$nombre = explode(".", $nombre);
			$cont =1;

			while ($nombre_img == $existe ) 
			{
				$nombre_img = explode(".", $nombre);
				$nombre_img = $nombre[0].$cont.".".$nombre[1];
				$sql = "SELECT imagenes.nombre_img FROM `imagenes` WHERE imagenes.nombre_img = '$nombre_img'";
				$resultado = $this->bd->query($sql);
				$resultado->num_rows === 1;
				$existe = $resultado->fetch_row();
				$existe = $existe[0];
				$cont++;
			}

			$nombre = $nombre_img;

			move_uploaded_file($_FILES['archivo']['tmp_name'], $this->rutaabsoluta.$nombre);

			$sql = "INSERT INTO imagenes(nombre_img, ruta) VALUES ('$nombre', '$rutaweb')";
	 		$this->bd->query($sql);
	 		$imagen_id = $this->bd->insert_id;
		}

	 		return $imagen_id;
	}

	public function insertar_video($posts)
	{

		$video_id = NULL;

		$video_youtube = explode("=", $posts['video_youtube']);
		$video_youtube = $video_youtube[1];

		$video_vimeo = explode("/", $posts['video_vimeo']);
		$video_vimeo = $video_vimeo[3];

		if (!empty($posts['video_youtube']) && !empty($posts['video_vimeo'])) 
		{

			$sql = "INSERT INTO videos(ruta_video, ruta_vimeo) VALUES ('$video_youtube', '$video_vimeo')";
	 		$this->bd->query($sql);
	 		$video_id = $this->bd->insert_id;

		}

		if (!empty($posts['video_youtube']) && empty($posts['video_vimeo'])) 
		{

			$sql = "INSERT INTO videos(ruta_video) VALUES ('$video_youtube')";
	 		$this->bd->query($sql);
	 		$video_id = $this->bd->insert_id;

		}

		if (empty($posts['video_youtube']) && !empty($posts['video_vimeo'])) 
		{

			$sql = "INSERT INTO videos(ruta_vimeo) VALUES ('$video_vimeo')";
	 		$this->bd->query($sql);
	 		$video_id = $this->bd->insert_id;

		}

	 	return $video_id;
		
	}

	public function modificar($post)
	{
		
		$sql = "SELECT posts.user_id FROM `posts` WHERE id = {$post['id']} ";
		$resultado = $this->bd->query($sql);
		$resultado = $resultado->fetch_assoc();

		if ($_SESSION['user'] == $resultado['user_id']) 
		{
			$sql = "UPDATE posts SET posts.titulo='{$post['titulo']}', posts.subtitulo = '{$post['subtitulo']}', posts.texto = '{$post['texto']}', posts.tema_id = '{$post['tema_id']}' WHERE posts.id={$post['id']} ";

			if(! $this->bd->query($sql)){
			     die('Ocurrio un error ejecutando el query [' . $this->bd->error . ']');
			}
		}
		else
		{
			$_SESSION['msg'] = "No puedes modificar un post que no es tuyo.";
		}
		header("Location: view.php?id={$post['id']}"); 
	}

	public function eliminar($id)
	{
		
		$sql = "SELECT posts.user_id FROM `posts` WHERE id = $id ";
		$resultado = $this->bd->query($sql);
		$resultado = $resultado->fetch_assoc();

		if ($_SESSION['user'] == $resultado['user_id']) 
		{	
			$sql = "SELECT imagenes.nombre_img FROM `posts` LEFT JOIN imagenes On posts.imagen_id=imagenes.id WHERE posts.id=$id";
			$resultado = $this->bd->query($sql);
			$nombre_img = $resultado->fetch_row();

			if (!empty($nombre_img[0])) {
				@unlink($this->rutaabsoluta.$nombre_img[0]);
			}

			$sql = "DELETE posts.*, imagenes.*, videos.* FROM posts LEFT JOIN imagenes ON posts.imagen_id = imagenes.id LEFT JOIN videos ON posts.video_id = videos.id WHERE posts.id=$id";

			if(! $this->bd->query($sql)){
			     die('Ocurrio un error ejecutando el query [' . $this->bd->error . ']');
			}
		}
		else
		{
			$_SESSION['msg'] = "No puedes eliminar un post que no es tuyo.";
		}
		header("Location: index.php");
	}

	public function listarfecha($fecha)
	{
		$sql = "SELECT posts.*, temas.nombre FROM posts LEFT JOIN temas ON posts.tema_id = temas.id WHERE date_format(fecha, '%m-%Y') = '$fecha' ORDER BY `posts`.`fecha` DESC ";

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
		$sql = "SELECT posts.*, temas.nombre FROM posts LEFT JOIN temas ON posts.tema_id = temas.id WHERE texto LIKE '%$busqueda%' OR titulo LIKE '%$busqueda%' OR subtitulo LIKE '%$busqueda%' ORDER BY posts.fecha DESC LIMIT 50";

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
			$_SESSION['admin'] = $user[4];
			$_SESSION['user'] = $user[0];
			header("Location: index.php");
		}
		else
		{
			unset($_SESSION['login']);
			unset($_SESSION['admin']);
			unset($_SESSION['user']);
			$_SESSION['msg'] = "Usuario o contraseña incorrectos.";
		}
	
	}

	public function logout()
	{

		unset($_SESSION['login']);
		unset($_SESSION['admin']);
		unset($_SESSION['user']);
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
		$sql = "SELECT * FROM `users` WHERE users.user = '$registro[usuario]'";

		if(!$resultado = $this->bd->query($sql)){
			    die('Ocurrio un error ejecutando el query [' . $this->bd->error . ']');
			}

		$resultado->num_rows === 1;
		$existe = $resultado->fetch_row();
		
		if (!empty($existe)) {
			$_SESSION['msg'] = "El usuario ya existe.";

		}

		else
		{
			if ($registro['password'] !== $registro['password1'] || $registro['password'] == $registro['usuario']) 
			{
				if ($registro['password'] !== $registro['password1']) {
					$_SESSION['msg'] = "Las contraseñas no coinciden.";
				}
				if ($registro['password'] == $registro['usuario']) {
					$_SESSION['msg'] = "El usuario y la contraseña no pueden ser iguales.";
				}
			}
			else
			{
				$sql = "INSERT INTO users(nombre, user, password, admin) VALUES ('".$registro['nombre']."','". $registro['usuario']."','".$registro['password']."', '".$registro['admin']."')";

				if(!$this->bd->query($sql)){
				     die('Ocurrio un error ejecutando el query [' . $this->bd->error . ']');
				}
				header("Location: index.php");
			}
		} 	
	}
}