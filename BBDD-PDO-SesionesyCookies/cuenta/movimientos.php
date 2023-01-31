<?php
include '../funciones.inc.php';
//Recuperar la sesion
session_start();
header('Cache-Control: no cache');

//Comprobamos que el usuario se ha autentificado
if (!isset($_SESSION['usuario'])) {
	die("Error -debe <a href='../index.php'>identificarse</a>");
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
		<h1>Gestión Personal: Movimientos</h1>
		<div id="nombre-usuario-cabecera">
			<i>Bienvenid@</i> <b> <?php echo $_SESSION['usuario'] ?></b>
		</div>
	</header>
	<nav>
		<span class="desplegable">
			<a href="./">Mi Cuenta</a>
			<div>
				<a href="movimientos.php">Ultimos Movimientos</a>
				<a href="ingresar.php">Contabilizar un Ingreso</a>
				<a href="pagar.php">Contabilizar un Gasto</a>
				<a href="devolver.php">Eliminar un movimiento</a>
				<a href="../">Salir</a>
			</div>
		</span>
		&gt; Últimos Movimientos
	</nav>
	<main>
		<?php
		$base = "conta2";
		$query = "select * from movimientos where loginUsu='" . $_SESSION['usuario'] . "' order by fecha asc";
		$con = conexion_bd($base);
		$result = $con->query($query);
		?>
		<table class="tabla">
			<thead>
				<tr>
					<th>CodMov</th>
					<th>Fecha</th>
					<th>Concepto</th>
					<th>Cantidad</th>
					<th>Saldo Contable</th>
				</tr>
				<?php
				$numMovimientos = 0;
				$saldoActual = 0;

				while ($reg = $result->fetch()) {

					//cuenta los registros, si no se encuentra ninguno, se pone a 0
					$numMovimientos = $result->rowCount();
					if ($numMovimientos == 0) {
						$numMovimientos = 0;
					} else {
						$numMovimientos = $numMovimientos;
					}

					//calcula el saldo total


					if (isset($_SESSION['usuario']) && isset($reg['fecha']) && isset($reg['codigoMov'])) {
						$saldoActual = getSaldo($_SESSION['usuario'], $reg['fecha'], $reg['codigoMov']);
					}

				?>

			</thead>
			<tbody>
				<tr>
					<th><?php echo $reg['codigoMov']; ?></th>
					<th><?php echo formatea_fecha($reg['fecha']) ?></th>
					<th><?php echo $reg['concepto']; ?></th>
					<th><?php echo $reg['cantidad']; ?></th>
					<th><?php echo getSaldo($_SESSION['usuario'], $reg['fecha'], $reg['codigoMov']) ?></th>
				</tr>
			<?php
				}
			?>
			</tbody>
			<tfoot>
				<tr>
					<th>Nº Mov</th>

					<th><?php echo $numMovimientos ?></th>
					<th colspan="2">Saldo Actual:</th>
					<th><?php echo $saldoActual ?></th>
				</tr>
			</tfoot>
		</table>
		<?php
		unset($conexion);
		?>
	</main>
</body>

</html>