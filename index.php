<?php
	include	"base-datos.php";

	$blog = new blog();
	if (isset($_GET['fecha']) || isset($_GET['tema']) || isset($_POST['busqueda'])) {
		if (isset($_GET['fecha'])) {
		$posts = $blog->listarfecha($_GET['fecha']);
		}
		elseif(isset($_GET['tema'])){
			$posts = $blog->listartema($_GET['tema']);
		}
		elseif(isset($_POST['busqueda'])){
			$posts = $blog->busqueda($_POST['busqueda']);
		}
	}
	else{
		$posts = $blog->listar();
	}
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

		<? if (isset($_SESSION['msg'])): ?>
			<div class="alert alert-danger" role="alert"><?=$_SESSION['msg']?></div>
			<? unset($_SESSION['msg']); ?>
		<? endif; ?>

		<div class="formulariobusqueda">
			<FORM METHOD=POST ACTION="index.php"> 
				<strong>Buscar: </strong><INPUT TYPE="text" NAME="busqueda" class="busqueda" value="<?if(!empty($_POST['busqueda'])) echo $_POST['busqueda']; ?>"> 
			</FORM>
			<?if ($posts->num_rows === 0): ?>
				<span>No se ha encontrado ningún resultado.</span>
			<?endif;?>
		</div>
		<span class="clear"></span>
		<div class="row">

			<div class="col-sm-8 blog-main">

				<?php while($fila = $posts->fetch_assoc()): ?>
					<div class="blog-post">
							<p>Tema: <strong> <?=$fila['nombre']?> </strong></p>
						<h2 class="blog-post-title">
							<a href="view.php?id=<?=$fila['id']?>">
								<?=$fila['titulo']?>
							</a>
						</h2>
						<p class="blog-post-meta"><?=$blog->formatFecha($fila['fecha'])?></p>
						<h3 class=""><?=$fila['subtitulo']?></h3>
						<p><?=$fila['texto']?></p>
						<?if (!empty($fila['nombre_img']) && !empty($fila['ruta'])): ?>
							<div>
								<a class="fancy" href="<?=$fila['ruta'].$fila['nombre_img'] ?>"><img src="<?=$fila['ruta'].$fila['nombre_img'] ?>" height="100" width="150"></a>
							</div>
						<?endif; ?>
						<? if(isset($_SESSION['login'])): ?>
							<div class="boton">
								<a href="modificar.php?id=<?=$fila['id']?>" class="btn btn-warning">Editar post</a>
								<a input type="button" class="btn btn-danger" value="Mostrar" onclick="mostrar(<?=$fila['id']?>)">Eliminar post</a>
								<div id="confirmacion_<?=$fila['id']?>" class="confirmacion" style='display:none;'>
									<span>¿Está seguro de que desea eliminar este post?</span>
									<a href="eliminar.php?id=<?=$fila['id']?>" class="btn btn-danger">Si</a>
									<a class="btn btn-warning" class ="no" onclick="ocultar(<?=$fila['id']?>)">No</a>
								</div>
							</div>
						<? endif; ?>
					</div>
				<?php endwhile; ?>
	</div>
	<?include "botones.php";?>
	<div class="col-sm-3 col-sm-offset-1 blog-sidebar">
		<div class=" sidebar-module sidebar-module-insert">
			<h4>Información</h4>
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec dapibus rhoncus pretium. In eget accumsan enim. Nunc vestibulum ultricies sapien. Donec eu mauris tincidunt, volutpat tellus quis, faucibus tortor.</p>
		</div>
		<div class="sidebar-module">
			<h4>Archivos</h4>
			<?php include "_lista.php" ?>
		</div>
		<div class="sidebar-module">
			<h4>Filtrar</h4>
			<?php include "_filtrar.php" ?>
		</div>
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