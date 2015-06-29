<div class="insertar">
	<? if(isset($_SESSION['login'])): ?>
		<? if($_SESSION['admin'] === '1'): ?>
			<a href="registro.php" class="btn btn-success">Registrar</a>
		<?endif?>
		<a href="insertar.php" class="btn btn-success">Añadir Post</a>
		<a href="logout.php" class="btn btn-danger">Cerrar sesión (<?=$_SESSION['login']?>)</a>
	<? else: ?>
		<a href="login.php" class="btn btn-success">Entrar</a>
	<? endif; ?>
</div>