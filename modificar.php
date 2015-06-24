<?php
	include "base-datos.php";
	$post = new blog();

	if (!empty($_POST)) {
 		$post->modificar($_POST);
	} else {
		$post_id = $_GET['id'];
 		$posts = $post->view($post_id);
 		$tema = $post->gettemas();
	}
	
?>
<!DOCTYPE HTML>
<html>
    <head>       
        <meta charset="utf-8"> 
        <title>Insertar artículo</title>
            <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/blog.css" rel="stylesheet">
    <script type="text/javascript" src="ckeditor/ckeditor.js"></script>	
    </head>
	<body>
		<div class="container">
			<form action="modificar.php" method="post">
				<div class="row">
					<br/> <br/>
					<br/> <br/>
					<?php while ($fila = $posts->fetch_assoc()): ?>
						<input type="hidden" name="id" value="<?=$fila['id']?>">
						<label for="titulo">Tema: </label>
						<select name="tema_id">
							<?php while($opt = $tema->fetch_assoc()): ?>
								<?php if($opt['id']==$fila['tema_id']): ?>
									<option value="<?=$opt['id']?>" selected> <?=$opt['nombre']?> </option>
								<?php else: ?>
									<option value="<?=$opt['id']?>"> <?=$opt['nombre']?> </option>
								<?php endif; ?>
							<?php endwhile; ?> 
						</select >
						<br/> <br/>
						<label for="titulo">Título: </label>
						<input type="text" name="titulo" id="titulo" value="<?=$fila['titulo']?>">
						<br/> <br/>
						<label for="subtitulo">Subtítulo: </label>
						<input type="text" name="subtitulo" id="subtitulo" value="<?=$fila['subtitulo']?>">
						<br/> <br/>
						<label for="texto">Texto: </label>
						<textarea cols='80' id='texto' name='texto' rows='10'><?=$fila['texto']?></textarea>
						<script type='text/javascript'>
						window.onload = function(){
						    CKEDITOR.replace('texto');
						 };
						</script>
						<br/> <br/>
						<input type="submit" value="Enviar">
						<input type="reset">
					<?php endwhile; ?>
				</div>
			</form>
			<br/> <br/>
			<a href="index.php" class="btn btn-danger">Volver a Inicio</a>
		</div>
	</body>
</html>



