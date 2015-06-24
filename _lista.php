<?php
	include_once "base-datos.php";

	$posts = new blog();
	$rango = $posts->getmonths();
	
	setlocale(LC_ALL,"es_ES");
	$fechainicial = new DateTime($rango['menor']);
	$fechafinal = new DateTime($rango['mayor']);
	$meses = $fechainicial->diff($fechafinal);
	$meses = ($meses->y * 12) + $meses->m;
?>

<ol class="list-unstyled">
	<?for ($i=0; $i <=$meses ; $i++): ?>
		<li>
			<a href="index.php?fecha=<?=$fechafinal->format('m-Y')?>"><?=$fechafinal->format('M Y')?></a> 
			<? $fechafinal->modify('-1 month') ?>
		</li>
	<?endfor; ?>
</ol>