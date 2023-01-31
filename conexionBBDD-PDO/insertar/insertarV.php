<?php
//codComercial, refProducto, cantidad, fecha

include '../config/misfunciones.php';
$cantidadErr = $fechaErr = "";

if (isset($_REQUEST['codigo'])) {
  $codComercial = $_REQUEST['codigo'];
} else {
  $codComercial = "";
}
if (isset($_REQUEST['referencia'])) {
  $refProducto = $_REQUEST['referencia'];
} else {
  $refProducto = "";
}
if (isset($_REQUEST['cantidad'])) {
  $cantidad = $_REQUEST['cantidad'];
} else {
  $cantidad = "";
}
if (isset($_REQUEST['fecha'])) {
  $fecha = $_REQUEST['fecha'];
} else {
  $fecha = "";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  //si el campo está vacío o no numero o es menor de 0 salta el error
  if (empty($_POST["cantidad"]) || !is_numeric($_POST["cantidad"]) || $_POST["cantidad"] < 0) {
    $cantidadErr = "Código incorrecto, debe ser numérico y mayor que 0";
  } else {
    $cantidad = test_input($_POST["cantidad"]);
  }

  //guarda la fecha actual y si es menor que la fecha de hoy salta el error
  if (empty($_POST["fecha"]) || $_POST["fecha"] > date("Y-m-d")) {
    $fechaErr = "Rellene la fecha, debe ser menor que la fecha actual";
  } else {
    $fecha = test_input($_POST["fecha"]);
  }
}

?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title>Insertar Comerciales</title>
  <link rel="stylesheet" type="text/css" href="../estilo/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="../estilo/estilos.css">
  <script src="../estilo/jquery.min.js"></script>
  <script src="../estilo/bootstrap.min.js"></script>
</head>

<body>

  <!-- MENU -->
  <div class="container">
    <h1>Base de Datos: Ventas y Comerciales</h1>
    <ul class="nav nav-tabs" role="tablist">
      <li><a href="../index.html">Principal</a></li>
      <li><a href="../listar.php">Listar</a></li>

      <li class="dropdown active">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
          Insertar <span class="caret"></span></a>
        <ul class="dropdown-menu" role="menu">
          <li><a href="../insertar/insertarC.php" class="active">Insertar Comerciales</a></li>
          <li><a href="../insertar/insertarP.php">Insertar Productos</a></li>
          <li><a href="../insertar/insertarV.php">Insertar Ventas</a></li>
        </ul>
      </li>
      <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
          Modificar <span class="caret"></span></a>
        <ul class="dropdown-menu" role="menu">
          <li><a href="../modificar/modificarC.php">Modificar Comerciales</a></li>
          <li><a href="../modificar/modificarP.php">Modificar Productos</a></li>
          <li><a href="../modificar/modificarV.php">Modificar Ventas</a></li>
        </ul>
      </li>
      <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
          Borrar <span class="caret"></span></a>
        <ul class="dropdown-menu" role="menu">
          <li><a href="../borrar/borrarC.php">Borrar Comerciales</a></li>
          <li><a href="../borrar/borrarP.php">Borrar Productos</a></li>
          <li><a href="../borrar/borrarV.php">Borrar Ventas</a></li>
        </ul>
      </li>
    </ul>
    <br>
    <h2>Insertar Venta</h2>

    <!-- FORMULARIO -->
    <form method="post" class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
      <div class="form-group">
        <label class="control-label col-sm-2" for="referencia">Comercial:</label>
        <div class="col-sm-10">
          <select name="codigo" class="form-control">
            <?php
            if (isset($_POST['codigo'])) $codigo = $_POST['codigo'];
            $bd = conectar("ventas_comerciales");
            $sql = "select codigo,nombre from comerciales";
            $resultado = $bd->query($sql);

            //desplegable para comerciales
            if ($resultado) {
              $row = $resultado->fetch();
              while ($row != null) {
                echo "<option value='${row['codigo']}'";
                if (isset($codigo) && $codigo == $row['codigo'])
                  echo " selected='true'"; //de esta manera se queda marcado el producto seleccionado
                echo ">${row['nombre']}</option>";
                $row = $resultado->fetch();
              }
            }
            ?>
          </select>
        </div>
      </div>

      <div class="form-group">
        <label class="control-label col-sm-2" for="referencia">Producto:</label>
        <div class="col-sm-10">
          <select name="referencia" class="form-control">
            <?php
            if (isset($_POST['referencia'])) $referencia = $_POST['referencia'];
            $bd = conectar("ventas_comerciales");
            $sql = "select referencia,nombre from productos";
            $resultado = $bd->query($sql);

            //desplegable para producto
            if ($resultado) {
              $row = $resultado->fetch();
              while ($row != null) {
                echo "<option value='${row['referencia']}'";
                if (isset($referencia) && $referencia == $row['referencia'])
                  echo " selected='true'";
                echo ">${row['nombre']}</option>";
                $row = $resultado->fetch();
              }
            }
            ?>
          </select>
        </div>
      </div>

      <div class="form-group">
        <label class="control-label col-sm-2" for="referencia">Cantidad:</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="cantidad" placeholder="Introduce la cantidad" value="<?php echo $cantidad; ?>">
        </div>
        <span class="error"><?php echo $cantidadErr; ?> </span>
      </div>
      <div class="form-group">
        <label class="control-label col-sm-2" for="fecha">Fecha:</label>
        <div class="col-sm-10">
          <input type="date" class="form-control" name="fecha" placeholder="Introduce la fecha" value="<?php echo $fecha; ?>">
        </div>
        <span class="error"><?php echo $fechaErr; ?> </span>
      </div>
      <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
          <button type="submit" class="btn btn-default">Insertar</button>
        </div>
      </div>
    </form>
  </div>

  <?php
  //si el metodo empleado es post y si no hay error, se inserta
  if (($_SERVER["REQUEST_METHOD"] == "POST") && ($cantidadErr == "" && $fechaErr == "")) {
    $sql = "INSERT INTO ventas (codComercial, refProducto, cantidad, fecha) VALUES ('$codComercial','$refProducto','$cantidad','$fecha')";
    $bd = "ventas_comerciales";
    operaciones($sql, $bd);
    echo "La venta ha sido añadido satisfactoriamente";
  }
  ?>


</body>

</html>