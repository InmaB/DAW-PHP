<?php
include '../funciones.inc.php';
//Recuperar la sesion
session_start();
header('Cache-Control: no cache');

//Comprobamos que el usuario se ha autentificado
if (!isset($_SESSION['admin'])) {
	die("Error -debe <a href='../index.php'>identificarse</a>");
}
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<title>Modificar Usuarios</title>
	<link rel="stylesheet" type="text/css" href="../css/estilos.css">
</head>

<body id="pagina-login">
	<?php

	if (isset($_POST['cargar'])) {
		$login = $_POST['select_login'];
		$query = "select * from usuarios where login='$login'";
		$registros = getRegistros($query, "conta2");
		$nombre = $registros['nombre'];
		$fNacimiento = $registros['fNacimiento'];
	}

	if (isset($_POST['guardar'])) { {
			$login = $_POST['login'];
			$password = $_POST['password'];
			$password2 = $_POST['repassword'];
			$nombre = $_POST['nombre'];
			$fNacimiento = $_POST['fNacimiento'];
		}

		$base = "conta2";
		$query = "update usuarios set login='$login',password='" . crypt($password, "XC") . "', nombre='$nombre', fNacimiento='$fNacimiento' where login='$login'";
		operaciones($query, "conta2");
		$correcto = "El usuario ha sido actualizado";
	}
	?>

	<header>
		<h1>Modificar usuarios</h1>
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
		&gt; Modificar Usuario
	</nav>
	<main>
		<fieldset class="mini-formulario">
			<legend>Modificar Datos Usuario</legend>
			<?php
			if (!empty($error)) {
				echo "<div class='error'><b>!</b>$error</div>";
			}
			if (!empty($correcto)) {
				echo "<div class='correcto'><b>!</b>$correcto</div>";
			}
			?>
			<form method="post" action="?<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
				<label>Selecciona Usuario</label>
				<select name="select_login" required>
					<?php
					if (isset($_POST['usuario'])) $usuario = $_POST['usuario'];
					selectUsuario();
					?>
				</select>
				<input type="submit" name="cargar" value="Cargar Datos del Usuario">
			</form>
			<hr>
			<?php

			?>
			<form method="post" action="?<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
				<div class="input-labeled">
					<label>Login:</label>
					<input type="text" name="login" required maxlength="10" readonly value="<?php echo (isset($login) && empty($correcto)) ? $login : ''; ?>">
				</div>
				<div class="input-labeled">
					<label>Clave:</label>
					<input type="password" name="password" placeholder="**********" maxlength="20">
				</div>
				<div class="input-labeled">
					<label>Repite Clave:</label>
					<input type="password" name="repassword" placeholder="**********" maxlength="20">
				</div>
				<div class="input-labeled">
					<label>Nombre:</label>
					<input type="text" name="nombre" required maxlength="30" value="<?php echo (isset($nombre) && empty($correcto)) ? $nombre : ''; ?>">
				</div>
				<div class="input-labeled">
					<label>Fecha Nacimiento:</label>
					<input type="date" name="fNacimiento" placeholder="aaaa-mm-dd" min="1930-01-01" max="2004-12-31" required maxlength="10" value="<?php echo (isset($fNacimiento) && empty($correcto)) ? $fNacimiento : ''; ?>">
				</div>
				<input type="submit" name="guardar" value="Guardar">
			</form>
			<?php
			unset($conexion);

			?>
		</fieldset>
	</main>
</body>

</html>