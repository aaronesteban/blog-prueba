<?
	include	"base-datos.php";

	$blog = new blog();
	if (empty($_GET['page'])) {
		$page = 1;
	} 
	else {
		$page = $_GET['page'];
	}

	$comienzo = $blog->numerocomienzopost($page);
	if (isset($_GET['fecha'])) {
		$cont = $blog->contarposts('fecha',$_GET['fecha']);
		$posts = $blog->listarfecha($_GET['fecha'], $comienzo);
	}
	elseif(isset($_GET['tema'])){
		$cont = $blog->contarposts('tema',$_GET['tema']);
		$posts = $blog->listartema($_GET['tema'], $comienzo);
	}
	elseif(isset($_POST['busqueda'])){
		$cont = $blog->contarposts('busqueda',$_POST['busqueda']);
		$posts = $blog->busqueda($_POST['busqueda'], $comienzo);
	}
	else{
		$cont = $cont = $blog->contarposts();
		$posts = $blog->listar($comienzo);
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
    
	<script src="http://code.jquery.com/jquery-latest.min.js"></script>
	<script type="text/javascript" src="js/jquery.fancybox.pack.js"></script>  
	<link rel="stylesheet" type="text/css" href="css/jquery.fancybox.css" />
	<link href="css/blog.css" rel="stylesheet">
</head>

<body>
	<div class="container">
		<header>
			<a href="index.php"><h1>Blog con php y mySQL</h1></a>
		</header>

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

				<? while($fila = $posts->fetch_assoc()): ?>
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
								<a class="fancy" href="<?=$fila['ruta'].$fila['nombre_img'] ?>"><img class ="imagen" src="<?=$fila['ruta'].$fila['nombre_img'] ?>"></a>
							</div>
						<?endif; ?>
						<?if (!empty($fila['ruta_video'])): ?>
							<div class="video">
								<iframe width="100%" src="https://www.youtube.com/embed/<?=($fila['ruta_video']); ?>" frameborder="0" allowfullscreen></iframe>
							</div>
						<?endif; ?>
						<?if (!empty($fila['ruta_vimeo'])): ?>
							<div class="video">
								<iframe src="//player.vimeo.com/video/<?=($fila['ruta_vimeo']); ?>"width="100%" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
							</div>
						<?endif; ?>
						<? if(isset($_SESSION['login'])): ?> 
							<? if ($_SESSION['user'] == $fila['user_id'] || $_SESSION['admin'] === '1'): ?>
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
						<? endif; ?>
					</div>
				<? endwhile; ?>
			</div>
			<?include "botones.php";?>
			<div class="col-sm-3 col-sm-offset-1 blog-sidebar">
				<div class=" sidebar-module sidebar-module-insert">
					<h4>Información</h4>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec dapibus rhoncus pretium. In eget accumsan enim. Nunc vestibulum ultricies sapien. Donec eu mauris tincidunt, volutpat tellus quis, faucibus tortor.</p>
				</div>
				<div class="sidebar-module">
					<h4>Archivos</h4>
					<? include "_lista.php" ?>
				</div>
				<div class="sidebar-module">
					<h4>Filtrar</h4>
					<? include "_filtrar.php" ?>
				</div>
			</div>
		</div>
		<div class="pagina">	
			<?include "paginas.php";?>
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

	    	$(window).resize(function(){
		    	var width = $('.video').width();
		    	height = width*3/4;
		    	$('.video iframe').css({'height':height});	    		
	    	});
	    	$(window).resize();
		});    
	</script>
</body>
</html>