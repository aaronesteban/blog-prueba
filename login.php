<?php

session_start();

include_once "base-datos.php";
$post = new blog();

if (!empty($_POST)) {
    $post->login ($_POST['usuario'],$_POST['password']);
}

?>

<meta charset="utf-8">
<form action="login.php" method="post">
    <table>
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
