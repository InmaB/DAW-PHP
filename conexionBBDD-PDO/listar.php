<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>Listar</title>
	<link rel="stylesheet" type="text/css" href="estilo/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="estilo/estilos.css">
	<script src="estilo/jquery.min.js"></script>
	<script src="estilo/bootstrap.min.js"></script>
</head>

<body>
	<div class="container">
		<h1>Base de Datos: Ventas y Comerciales</h1>
		<ul class="nav nav-tabs" role="tablist">
			<li><a href="index.html">Principal</a></li>
			<li class="active"><a href="listar.php">Listar</a></li>

			<li class="dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown" href="#">
					Insertar <span class="caret"></span></a>
				<ul class="dropdown-menu" role="menu">
					<li><a href="insertar/insertarC.php">Insertar Comerciales</a></li>
					<li><a href="insertar/insertarP.php">Insertar Productos</a></li>
					<li><a href="insertar/insertarV.php">Insertar Ventas</a></li>
				</ul>
			</li>
			<li class="dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown" href="#">
					Modificar <span class="caret"></span></a>
				<ul class="dropdown-menu" role="menu">
					<li><a href="modificar/modificarC.php">Modificar Comerciales</a></li>
					<li><a href="modificar/modificarP.php">Modificar Productos</a></li>
					<li><a href="modificar/modificarV.php">Modificar Ventas</a></li>
				</ul>
			</li>
			<li class="dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown" href="#">
					Borrar <span class="caret"></span></a>
				<ul class="dropdown-menu" role="menu">
					<li><a href="borrar/borrarC.php">Borrar Comerciales</a></li>
					<li><a href="borrar/borrarP.php">Borrar Productos</a></li>
					<li><a href="borrar/borrarV.php">Borrar Ventas</a></li>
				</ul>
			</li>
		</ul>
		<br>
		<h2>Consultar Base de Datos</h2>



		<?php
		include 'config/misfunciones.php';

		//Listado de datos
		$conexion = conectar("ventas_comerciales");
		$query = "select * from comerciales";
		$registros = $conexion->query($query) or die($conexion->error);
		?>

		<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
			<table width="50%" border="0" align="center">
				<tr>
					<th>Nombre del Comercial</th>
				</tr>

				<?php
				$row = $registros->fetch();
				while ($row != null) {
				?>
					<tr>
						<td>
							<select name='listar'>
								<!-- lista los nombres de los comerciales a consultar -->
								<?php
								$conexion = conectar("ventas_comerciales");
								$query = "select * from comerciales";
								$registros = $conexion->query($query) or die($conexion->error);
								$row = $registros->fetch();
								while ($row != null) {

								?>
									<option value="<?php echo $row['codigo']; ?>"><?php echo $row['nombre'] ?></option>

								<?php

									$row = $registros->fetch();
								}
								$conexion = null;
								?>
							</select>
						<?php
						$row = $registros->fetch();
					}
					$conexion = null;
						?>
						<input type='submit' name='consulta' id='consulta' value='consultar' class="btn btn-default">
						</td>
					</tr>

			</table>
			<br>

			<!-- Tabla que muestra la consulta -->
			<table width="50%" border="0" align="center" class="table">
				<?php
				if (isset($_POST['consulta'])) {
					$codigo = $_POST['listar'];
					$query = "select referencia, productos.nombre, descripcion, precio, descuento, cantidad, fecha
                            from productos inner join ventas on refProducto = referencia
                            inner join comerciales on codigo = codComercial
                            where codigo = '$codigo'";
					$base = "ventas_comerciales";
					$conexion = conectar($base);
					$registros = $conexion->query($query) or die($conexion->error);
					$row = $registros->fetch();
					echo "<tr>
                            <th>Referencia</th>
                            <th>Nombre</th>
                            <th>Descripcion</th>
                            <th>Precio</th>
                            <th>Descuento</th>
                            <th>Cantidad</th>
                            <th>Fecha</th>
                        </tr>";
					while ($row != null) {
						echo "<tr>";
						echo "<td>" . $row['referencia'] . "</td>";
						echo "<td>" . $row['nombre'] . "</td>";
						echo "<td>" . $row['descripcion'] . "</td>";
						echo "<td>" . $row['precio'] . "</td>";
						echo "<td>" . $row['descuento'] . "</td>";
						echo "<td>" . $row['cantidad'] . "</td>";
						echo "<td>" . $row['fecha'] . "</td>";
						echo "</tr>";
						$row = $registros->fetch();
					}
				} ?>
			</table>

		</form>
	</div>
</body>

</html>