<?php
	include "base-datos.php";
	$temp = new blog();
	$posts = $_GET;
?>
<!DOCTYPE HTML>
<html>
    <head>       
        <meta charset="utf-8"> 
        <title>Insertar artículo</title>
            <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    </head>
	<body>
		<div class="container">
			<form action="insertar.php" method="get">
				<div class="row">
					<br/> <br/>
					<br/> <br/>
					<label for="titulo">Título: </label>
					<input type="text" name="titulo" id="titulo">
					<br/> <br/>
					<label for="subtitulo">Subtítulo: </label>
					<input type="text" name="subtitulo" id="subtitulo">
					<br/> <br/>
					<label for="texto">Texto: </label>
					<input type="text" name="texto" id="texto">
					<br/> <br/>
	<!-- 				<label for="fecha">Fecha: </label>
					<input type="date" name="fecha" id="fecha">
					<br/> <br/> -->
					<input type="submit" value="Enviar">
					<input type="reset">
				</div>
			</form>
			<?php
			if (!empty($posts)) {
				$temp->insertar($posts);
			}
			?>
			<br/> <br/>
			<a href="index.php" class="btn btn-danger">Volver a Inicio</a>
		</div>
	</body>
</html>



