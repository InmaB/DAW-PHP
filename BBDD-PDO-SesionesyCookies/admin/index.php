<?php
include '../funciones.inc.php';

//Recuperar la sesion
session_start();

//Comprobamos que el usuario se ha autentificado
if (!isset($_SESSION['admin'])) {
  die("Error -debe <a href='../index.php'>identificarse</a> - ");
}

?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title>Gestión de Usuarios</title>
  <link rel="stylesheet" type="text/css" href="../css/estilos.css">
</head>

<body>
  <header>
    <h1>Gestión de Usuarios</h1>
  </header>
  <nav>Administrar Usuarios</nav>
  <main>
    <div id="menu">
      <a href="nuevo_usuario.php">Nuevo Usuario</a>
      <a href="modificar_usuario.php">Modificar Usuario</a>
      <a href="borrar_usuario.php">Borrar Usuario</a>
      <a href="../logoff.php">Salir</a>
    </div>
  </main>
</body>

</html>