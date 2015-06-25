<?php

include_once "base-datos.php";
$post = new blog();

if (!empty($_POST)) {
    $post->login ($_POST['usuario'],$_POST['password']);
}

?>
<html>
    <head>
        <meta charset="utf-8">
            <!-- Bootstrap core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/blog.css" rel="stylesheet">
    </head>
    <body>
        <div class="container">
            <form action="login.php" method="post">
                <table class="login">
                    <tr>
                        <td>Usuario:</td>
                        <td><input name="usuario" required="required" type="text" /></td>
                    </tr>
                    <tr>
                        <td>Password:</td>
                        <td><input name="password" required="required" type="password" /></td> 
                    </tr>
                    <tr>
                        <td colspan="2"><input name="iniciar" type="submit" value="Iniciar Sesión" /></td>
                    </tr>
                </table>
            </form>
            <? if (isset($_SESSION['msg'])): ?>
                <div class="alert alert-danger" role="alert"><?=$_SESSION['msg']?></div>
                <? unset($_SESSION['msg']); ?>
            <? endif; ?>
        </div>    
    </body>
</html>