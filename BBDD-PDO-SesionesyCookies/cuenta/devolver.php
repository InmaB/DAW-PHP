<?php
include '../funciones.inc.php';
//Recuperar la sesion
session_start();
header('Cache-Control: no cache');

//Comprobamos que el usuario se ha autentificado
if (!isset($_SESSION['usuario'])) {
	die("Error -debe <a href='../index.php'>identificarse</a>");
}
$query = "SELECT * FROM movimientos WHERE loginUsu='" . $_SESSION['usuario'] . "'";
$con = conexion_bd("conta2");
$result = $con->query($query);
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
		<h1>Gestión Personal: Eliminar</h1>
		<div id="nombre-usuario-cabecera">
			<i>Bienvenid@</i> <b> <?php echo $_SESSION['usuario'] ?></b>
		</div>
	</header>
	<nav>
		<span class="desplegable">
			<a href="./?<?php  ?>">Mi Cuenta</a>
			<div>
				<a href="movimientos.php?<?php  ?>">Ultimos Movimientos</a>
				<a href="ingresar.php?<?php  ?>">Contabilizar un Ingreso</a>
				<a href="pagar.php?<?php  ?>">Contabilizar un Gasto</a>
				<a href="devolver.php?<?php  ?>">Eliminar un movimiento</a>
				<a href="../">Salir</a>
			</div>
		</span>
		&gt; Eliminar un movimiento
	</nav>
	<main>
		<?php
		if (isset($_POST['devolver'])) {
			$codigoMov = $_POST['devolver'];
			$base = conexion_bd("conta2");
			$query = "DELETE FROM movimientos WHERE codigoMov = '" . $codigoMov . "'";
			operaciones($query, "conta2");
			header("Location: devolver.php");
		}
		?>
		<form method='post' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
			<table class="tabla">
				<thead>
					<tr>
						<th>Fecha</th>
						<th>Concepto</th>
						<th>Cantidad</th>
						<td></td>
						</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$reg = $result->fetch();
					while ($reg != null) {
						echo "<tr>";
						echo "<td>" . $reg['fecha'] . "</td>";
						echo "<td>" . $reg['concepto'] . "</td>";
						echo "<td>" . $reg['cantidad'] . "</td>";
						echo "<td><button class='devolver' name='devolver' value='" . $reg['codigoMov'] . "'>Devolver</button></td>";
						echo "</tr>";
						$reg = $result->fetch();
					}
					unset($conexion);
					?>
				</tbody>
				<tfoot>
					<tr>
						<th colspan="4"></th>
					</tr>
				</tfoot>
			</table>
		</form>
		<?php
		if (isset($_POST['devolver']))
			echo "<div class='correcto'>Operación realizada</div>";
		?>
	</main>
</body>

</html>