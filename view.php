<?php
	include	"base-datos.php";

	$post = new blog();
	$posts = $post->view($_GET["id"]);
?>
<!DOCTYPE html>
<html lang="es">

	<head>
	    <meta charset="utf-8">
	    <meta name="BLOG" content="width=device-width, initial-scale=1.0">
	    <meta name="description" content="">
	    <meta name="author" content="">

	    <title>Blog en php</title>

	    <!-- Bootstrap core CSS -->
	    <link href="css/bootstrap.min.css" rel="stylesheet">
	    <link href="css/blog.css" rel="stylesheet">
	    <script src="http://code.jquery.com/jquery-latest.min.js"></script>
	    <script type="text/javascript" src="js/jquery.fancybox.pack.js"></script>  
		<link rel="stylesheet" type="text/css" href="css/jquery.fancybox.css" />
	</head>

	<body>
		<div class="container">

			<a href="index.php"><h1>Blog con php y mySQL</h1></a>

			<div class="row">

				<div class="col-sm-8 blog-main">

					<?php 
						while ($fila = $posts->fetch_assoc()): ?>
							<div class="blog-post">
								<p>Tema: <strong> <?=$fila['nombre']?> </strong></p>
								<h2 class="blog-post-title">
									<?=$fila['titulo']?>
								</h2>
								<p class="blog-post-meta"><?=$fila['fecha']?></p>
								<h3 class=""><?=$fila['subtitulo']?></h3>
								<p><?=$fila['texto']?></p>
								<?if (!empty($fila['nombre_img']) && !empty($fila['ruta'])): ?>
									<div>
										<a class="fancy" href="<?=$fila['ruta'].$fila['nombre_img'] ?>"><img src="<?=$fila['ruta'].$fila['nombre_img'] ?>"width="150"></a>
									</div>
								<?endif; ?>
								<div class="boton">
									<a href="modificar.php?id=<?=$fila['id']?>" class="btn btn-warning">Editar post</a>
									<a input type="button" class="btn btn-danger" value="Mostrar" onclick="mostrar(<?=$fila['id']?>)">Eliminar post</a>
									<div id="confirmacion_<?=$fila['id']?>" class="confirmacion" style='display:none;'>
										<span>¿Está seguro de que desea eliminar este post?</span>
										<a href="eliminar.php?id=<?=$fila['id']?>" class="btn btn-danger">Si</a>
										<a class="btn btn-warning" class ="no" onclick="ocultar(<?=$fila['id']?>)">No</a>
									</div>
								</div>
						<?php endwhile; ?>
				</div>
				<a href="index.php" class="btn btn-danger">Volver a Inicio</a>			
			</div>
			<?include "botones.php";?>
		</div>
		<script type="text/javascript">
			function mostrar(id){
				document.getElementById('confirmacion_'+id).style.display = 'block';
				return false;
			}

			function ocultar(id){
				document.getElementById('confirmacion_'+id).style.display = 'none';
			}

			$(document).ready(function(){  
    		$(".fancy").fancybox({ });  
			}); 
	</script>
	</body>
</html>
