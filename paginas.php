<?if ($cont > 1): ?> 
	<?for ($i=1; $i <= $cont ; $i++):?>
		<?
		if (isset($_GET['fecha'])) {
			$url = "index.php?page=$i&fecha=" . $_GET['fecha'];
		}
		elseif(isset($_GET['tema'])){
			$url = "index.php?page=$i&tema=" . $_GET['tema'];
		}
		elseif(isset($_POST['busqueda'])){
			$url = "index.php?page=$i&busqueda=" . $_POST['busqueda'];
		}
		else{
			$url = "index.php?page=$i";
		}
		?>
		<? if ($page == $i): ?>
			<span class="current"><?=$i?></span>
		<? else: ?>
			<a href="<?=$url?>"><?=$i?></a>
		<? endif; ?>
	<?endfor;?>
<?endif;?>