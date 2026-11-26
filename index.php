
<?php
session_start();

if(!isset($_SESSION['id_usuario'])){
    header('location: login.php');
    exit();
}

include('menu.php');
?>

<h2>Bienvenido(a) <?=$_SESSION['nombre_usuario'] ?></h2>

</body>
</html>
