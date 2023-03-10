<?php
include '../funciones.inc.php';
//Recuperar la sesion
session_start();
header('Cache-Control: no cache');

//Comprobamos que el usuario se ha autentificado
if (!isset($_SESSION['usuario'])) {
	die("Error -debe <a href='../index.php'>identificarse</a>");
}

$error = "";

//se guardan las variables de sesion en variables
if (isset($_REQUEST['codigoMov'])) {
	$codigoMov = $_REQUEST['codigoMov'];
} else {
	$codigoMov = "";
}
if (isset($_REQUEST['loginUsu'])) {
	$loginUsu = $_REQUEST['loginUsu'];
} else {
	$loginUsu = "";
}
if (isset($_REQUEST['fecha'])) {
	$fecha = $_REQUEST['fecha'];
} else {
	$fecha = "";
}
if (isset($_REQUEST['concepto'])) {
	$concepto = $_REQUEST['concepto'];
} else {
	$concepto = "";
}
if (isset($_REQUEST['cantidad'])) {
	$cantidad = $_REQUEST['cantidad'];
	$cantidad *= -1;
} else {
	$cantidad = "";
}
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<title>Gestión Personal</title>
	<link rel="stylesheet" type="text/css" href="../css/estilos.css">
</head>

<body>
	<header>
		<h1>Gestión Personal: Gastos</h1>
		<div id="nombre-usuario-cabecera">
			<i>Bienvenid@</i> <b> <?php echo $_SESSION['usuario'] ?></b>
		</div>
	</header>
	<nav>
		<span class="desplegable">
			<a href="./?<?php   ?>">Mi Cuenta</a>
			<div>
				<a href="movimientos.php?<?php   ?>">Ultimos Movimientos</a>
				<a href="ingresar.php?<?php  ?>">Contabilizar un ingreso</a>
				<a href="pagar.php?<?php  ?>">Contabilizar un Gasto</a>
				<a href="devolver.php?<?php  ?>">Eliminar movimiento</a>
				<a href="../">Salir</a>
			</div>
		</span>
		&gt; Contabilizar un Gasto
	</nav>
	<main>
		<form method="post" class="formulario" action="?<?php  ?>">
			<table>
				<tfoot>
					<tr>
						<td colspan="2">
							<?php
							if (!empty($error)) {
								echo '<div class="error"><b>!</b>' . $error . '</div>';
							}
							?>
						</td>
					</tr>
				</tfoot>
				<tbody>
					<tr>
						<td><label>Fecha:</label></td>
						<td>
							<input type="date" name="fecha" value="<?php  ?>" size="10" placeholder="aaaa-mm-dd" maxlength="10" required>
						</td>
					</tr>
					<tr>
						<td><label>Concepto:</label></td>
						<td>
							<input type="text" name="concepto" value="<?php  ?>" size="20" placeholder="Descripción Movimiento" maxlength="20" required>
						</td>
					</tr>
					<tr>
						<td><label>Cantidad:</label></td>
						<td>
							<input type="number" name="cantidad" value="<?php  ?>" min="0" step="0.01" required>
							<input type="submit" name="pagar" value="Pagar">
						</td>
					</tr>
				</tbody>
			</table>
		</form>
	</main>
	<?php
	if (($_SERVER["REQUEST_METHOD"] == "POST") && (empty($error))) {
		do {
			//generamos un codigo aleatorio
			$bytes = random_bytes(2);
			$bytes = bin2hex($bytes);
		} while (existsMov($bytes, "conta2"));
		$query = "insert into movimientos(codigoMov, loginUsu, fecha, concepto, cantidad)values('$bytes', '" . $_SESSION['usuario'] . "', '$fecha','$concepto','$cantidad')";
		$bd = "conta2";
		operaciones($query, $bd);
		echo "<div class='correcto'>Pagado satisfactoriamente</div>";
	}
	?>
</body>

</html>