<?php
include '../funciones.inc.php';
//Recuperar la sesion
session_start();
header('Cache-Control: no cache');

//Comprobamos que el admin se ha autentificado
if (!isset($_SESSION['admin'])) {
	die("Error -debe <a href='../index.php'>identificarse</a>");
}
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<title>Borrar Usuarios</title>
	<link rel="stylesheet" type="text/css" href="../css/estilos.css">
</head>

<body id="pagina-login">
	<header>
		<h1>Borrar Usuarios</h1>
	</header>
	<nav>
		<span class="desplegable">
			<a href="index.php">Administrar Usuarios</a>
			<div>
				<a href="nuevo_usuario.php">Nuevo Usuario</a>
				<a href="modificar_usuario.php">Modificar Usuario</a>
				<a href="borrar_usuario.php">Borrar Usuario</a>
				<a href="../logoff.php">Salir</a>
			</div>
		</span>
		&gt; Borrar Usuario
	</nav>
	<main>
		<fieldset class="mini-formulario">
			<legend>Borrar Usuario</legend>
			<form method="post" action="?<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
				<label>Selecciona Usuario</label>
				<select name="borrar-usuario" required>
					<?php
					//si existe borrar, realizamos la consulta y su correspondiente operación
					if (isset($_POST['borrar'])) {
						borrar_usuario($_POST['borrar-usuario']);
					}
					//si existe usuario mostramos los usuarios
					if (isset($_POST['usuario'])) $usuario = $_POST['usuario'];
					selectUsuario();
					?>
				</select>
				<input type="submit" name="borrar" value="Borrar">
			</form>
			<?php
			if (isset($_POST['borrar']))
				echo "<div class='correcto'>El usuario ha sido borrado satisfactoriamente</div>";

			if (isset($error)) {
				echo "<div class='error'>$error</div>";
			}
			?>
		</fieldset>
	</main>
	<?php ?>
</body>

</html>