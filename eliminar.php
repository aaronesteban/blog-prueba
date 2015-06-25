<?php
	include "base-datos.php";
	$post = new blog();

	if (!$post->isloged()) {
		$_SESSION['msg'] = "No estás logueado";
		header("Location: index.php");
	}
	else
	{
		$post_id = $_GET['id'];
		$post->eliminar($_GET["id"]);
	}
?>

