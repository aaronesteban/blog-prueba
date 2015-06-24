<?php
	include "base-datos.php";
	$post = new blog();
	$post_id = $_GET['id'];
	$post->eliminar($_GET["id"]);
