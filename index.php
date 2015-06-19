<?php
	include	"base-datos.php";

	$temp = new blog();
	$posts = $temp->listar();
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

</head>

<body>
	<div class="container">

		<h1>Blog</h1>

		<div class="row">

			<div class="col-sm-8 blog-main">

				<?php while($fila = $posts->fetch_assoc()): ?>
					<div class="blog-post">
						<h2 class="blog-post-title">
							<a href="view.php?id=<?=$fila['id']?>">
								<?=$fila['titulo']?>
							</a>
						</h2>
						<p class="blog-post-meta"><?=$fila['fecha']?></p>
						<h3 class=""><?=$fila['subtitulo']?></h3>
						<p><?=$fila['texto']?></p>
					</div>
				<?php endwhile; ?>

			</div>

		</div>
	</div>



</body>
</html>