<?php
include '../funciones.inc.php';
//Recuperar la sesion
session_start();
header('Cache-Control: no cache');

//Comprobamos que el usuario se ha autentificado
if (!isset($_SESSION['admin'])) {
	die("Error -debe <a href='../index.php'>identificarse</a>");
}


if (isset($_POST['crear'])) {
	$login = $_POST['login'];
	$password = $_POST['password'];
	$password2 = $_POST['repassword'];
	$nombre = $_POST['nombre'];
	$fNacimiento = $_POST['fNacimiento'];
	$presupuesto = $_POST['presupuesto'];
	$error = "";

	//validación de campos
	if (empty($login) || empty($password) || empty($password2) || empty($nombre) || empty($fNacimiento) || empty($presupuesto)) {
		$error = $error . "Debe de completar todos los campos.<br>";
	} else {
		//Conexion a la base de datos
		$con = conexion_bd("conta2");
		//Comprobar si login existe en la base de datos
		if (existe_login($login, $con))
			$error .= "El login elegido ya existe en la BD.<br>";
		//Comprobar que las passwords coinciden
		if (strcmp($password, $password2) != 0)
			$error .= "Las contraseñas deben ser iguales.<br>";
		//La contraseña debe tener 6 o mas caracteres
		if (!comprueba_tamanio_contrasenia($password))
			$error .= "La contraseña debe tener un mínimo de 6 caracteres.<br>";
		//Comprobar que la contraseña tenga una letra minuscula por lo menos
		if (!comprueba_minus_contrasenia($password))
			$error .= "La contraseña debe tener minusculas.<br>";
		//Comprobar que la contraseña tenga una letra mayusculas por lo menos
		if (!comprueba_mayus_contrasenia($password))
			$error .= "La contraseña debe tener mayusculas.<br>";
		//Comprobar que tiene numeros la contraseña
		if (!comprueba_num_contrasenia($password))
			$error .= "La contraseña debe tener números.<br>";
		//Si no hay errores, insertar en la base de datos

		//Si los datos son correctos doy de alta al nuevo usuario. Aquí pone un error en global con todas las variables
		if (strcmp($error, "") == 0) {
			if (inserta_usuario($login, $password, $nombre, $fNacimiento, $presupuesto, $con)) {
				$correcto = "Usuario registrado correctamente";
				inserta_movimiento(1, $login, "0000/00/00", "Inicial Presupuesto", $presupuesto);
			} else {
				$error = "Ha ocurrido un error en el registro";
			}
		}

		unset($con);
	}
}



?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<title>Creación de Usuarios</title>
	<link rel="stylesheet" type="text/css" href="../css/estilos.css">
</head>

<body id="pagina-login">
	<header>
		<h1>Creación de Usuarios</h1>
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
		&gt; Nuevo Usuario
	</nav>
	<main>
		<fieldset class="mini-formulario">
			<legend>Datos Nuevo Usuario</legend>
			<?php
			if (!empty($error)) {
				echo "<div class='error'><b>!</b>$error</div>";
			}
			if (!empty($correcto)) {
				echo "<div class='correcto'><b>!</b>$correcto</div>";
			}
			?>
			<form method="post">
				<div class="input-labeled">
					<label>Login:</label>
					<input type="text" name="login" required maxlength="10" value="<?php echo (isset($login) && empty($correcto)) ? $login : ''; ?>">
				</div>
				<div class="input-labeled">
					<label>Clave:</label>
					<input type="password" name="password" required maxlength="20" value="<?php echo (isset($password) && empty($correcto)) ? $password : ''; ?>">
				</div>
				<div class="input-labeled">
					<label>Repite Clave:</label>
					<input type="password" name="repassword" required maxlength="20">
				</div>
				<div class="input-labeled">
					<label>Nombre:</label>
					<input type="text" name="nombre" required maxlength="30" value="<?php echo (isset($nombre) && empty($correcto)) ? $nombre : ''; ?>">
				</div>
				<div class="input-labeled">
					<label>Fecha Nacimiento:</label>
					<input type="date" name="fNacimiento" placeholder="aaaa-mm-dd" min="1930-01-01" max="2004-12-31" required maxlength="10" value="<?php echo (isset($fNacimiento) && empty($correcto)) ? $fNacimiento : ''; ?>">
				</div>
				<div class="input-labeled">
					<label>Presupuesto:</label>
					<input type="text" name="presupuesto" required maxlength="30" value="<?php echo (isset($presupuesto) && empty($correcto)) ? $presupuesto : ''; ?>">
				</div>
				<input type="submit" name="crear" value="Crear Usuario">
			</form>
		</fieldset>
	</main>
</body>

</html>