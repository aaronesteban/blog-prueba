<?php

include_once "base-datos.php";
$post = new blog();

$registro = $_POST;
if (!empty($registro))
{
    $post->registrarse ($registro);
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
            <form action="registro.php" method="post">
                <table class="login">
                    <tr>
                        <td>Nombre:</td>
                        <td><input name="nombre" required="required" type="text" value="<?if(!empty($_POST['nombre'])) echo $_POST['nombre']; ?>" /></td>
                    </tr>
                    <tr>
                        <td>Usuario:</td>
                        <td><input name="usuario" required="required" type="text" value="<?if(!empty($_POST['usuario'])) echo $_POST['usuario']; ?>" /></td>
                    </tr>
                    <tr>
                        <td>Password:</td>
                        <td><input name="password" required="required" type="password" /></td> 
                    </tr>
                    <tr>
                        <td>Confirme Password:</td>
                        <td><input name="password1" required="required" type="password" /></td> 
                    </tr>
                    <tr>
                        <td>Administrador:</td>
                        <td>
                            <SELECT name="admin"> 
                            <OPTION VALUE=1> Sí
                            <OPTION SELECTED VALUE=0> No
                            </SELECT> 
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"><input name="iniciar" type="submit" value="Registrarse" /></td>
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