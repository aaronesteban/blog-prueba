<?php
	include "base-datos.php";
	$bd = new blog();

	if (!$bd->isloged()) {
		$_SESSION['msg'] = "No estás logueado";
		header("Location: index.php");
	}

	$posts = $_POST;
	if (!empty($posts)) 
	{
		if ($_FILES ['archivo']['error'] > 0) {
			
		}
		else
		{
			$nombre = $_FILES['archivo']['name'];
			$imagen_id = $bd->insertar_imagen($bd->rutaweb, $nombre);
		}

		$video_id = $bd->insertar_video($posts);
		$bd->insertar($posts, $imagen_id, $video_id, $video_vimeo);
	}
	$tema = $bd->gettemas();
?>
<!DOCTYPE HTML>
<html>
    <head>       
        <meta charset="utf-8"> 
        <title>Insertar artículo</title>
            <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/blog.css" rel="stylesheet">
    		<!-- ckeditor -->
    <script type="text/javascript" src="ckeditor/ckeditor.js"></script>
 
    </head>
	<body>
		<div class="container">
			<form action="insertar.php" enctype="multipart/form-data" method="POST">
				<div class="row">
					<br/> <br/>
					<br/> <br/>
					<label for="titulo">Tema: </label>
					<select name="tema_id">
						<?php while($fila = $tema->fetch_assoc()): ?>
						<option value="<?=$fila['id']?>"> <?=$fila['nombre']?> </option>
						<?php endwhile; ?> 
					</select >
					<br/> <br/>
					<label for="titulo">Título: </label>
					<input type="text" name="titulo" id="titulo">
					<br/> <br/>
					<label for="subtitulo">Subtítulo: </label>
					<input type="text" name="subtitulo" id="subtitulo">
					<br/> <br/>
					<label for="texto">Texto: </label>
					<textarea cols="80" id="texto" name="texto" rows="10"></textarea>
					<script type='text/javascript'>
					window.onload = function(){
					    CKEDITOR.replace('texto');
					 };
					</script>
					<br/> <br/>
					<input type="file" name="archivo" id="archivo"></input>
					<br/> <br/>
					<label for="video">Vídeo youtube: </label>
					<textarea cols='120' id='video' name='video_youtube' rows='1' placeholder= "Copie la url entera de youtube."></textarea>
					<br/> <br/>
					<label for="video">Vídeo vimeo: </label>
					<textarea cols='120' id='video_vimeo' name='video_vimeo' rows='1' placeholder= "Copie la url entera de vimeo."></textarea>
					<br/> <br/>
					<input type="submit" value="Enviar">
					<input type="reset">
				</div>
			</form>
			<br/> <br/>
			<a href="index.php" class="btn btn-danger">Volver a Inicio</a>
		</div>
	</body>
</html>



