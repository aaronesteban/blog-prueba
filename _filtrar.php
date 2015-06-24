<?php
	include_once "base-datos.php";

	$posts = new blog();
	$temas = $posts->gettemas();
?>

<ol class="list-unstyled">
	<?while ($tema=$temas->fetch_assoc()):?>
		<li>
			<a href="index.php?tema=<?=$tema['id']?>"><?=$tema['nombre']?></a> 
		</li>
	<?endwhile;?>
</ol>