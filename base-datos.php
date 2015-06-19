<?php

//CLASES

class blog
{
	public $id;
	public $titulo;
	public $subtitulo;
	public $texto;
	public $fecha;
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
		$sql = "SELECT * FROM posts";

		if (!$resultado = $this->bd->query($sql)) 
		{
			die ('Ocurrio un error ejecutando el query [' . $bd->error .']');
		}
		return $resultado;

	}

	public function view($id=null)
	{
		$sql = "SELECT * FROM posts WHERE id=$id";

		if (!$resultado = $this->bd->query($sql)) 
		{
			die ('Ocurrio un error ejecutando el query [' . $bd->error .']');
		}
		return $resultado;

	}

	public function insertar($posts)
	{

		$sql = "INSERT INTO posts(titulo, subtitulo, texto) VALUES ('".$posts['titulo']."','". $posts['subtitulo']."','".$posts['texto']."')";

		if(! $this->bd->query($sql)){
		     die('Ocurrio un error ejecutando el query [' . $this->bd->error . ']');
		}
		echo 'Filas Insertadas: '.$this->bd->affected_rows;
	}

}


