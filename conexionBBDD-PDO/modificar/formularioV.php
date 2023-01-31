<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="../estilo/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="../estilo/estilos.css">
  <script src="../estilo/jquery.min.js"></script>
  <script src="../estilo/bootstrap.min.js"></script>
</head>

<body>

  <div class="container">
    <h1>Base de Datos: Ventas y Comerciales</h1>
    <ul class="nav nav-tabs" role="tablist">
      <li><a href="../index.html">Principal</a></li>
      <li><a href="../listar.php">Listar</a></li>

      <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
          Insertar <span class="caret"></span></a>
        <ul class="dropdown-menu" role="menu">
          <li><a href="../insertar/insertarC.php" class="active">Insertar Comerciales</a></li>
          <li><a href="../insertar/insertarP.php">Insertar Productos</a></li>
          <li><a href="../insertar/insertarV.php">Insertar Ventas</a></li>
        </ul>
      </li>
      <li class="dropdown active">
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
    <h2>Modificar Venta</h2>
    <?php
    include '../config/misfunciones.php';
    //Si no existe actualizar lo coge
    if (!isset($_POST['actualizar'])) {
      $codComercial = $_GET['codComercial'];
      $refProducto = $_GET['refProducto'];
      $cantidad = $_GET['cantidad'];
      $fecha = $_GET['fecha'];
    } else {
      $codComercial = $_POST['codComercial'];
      $refProducto = $_POST['refProducto'];
      $cantidad = $_POST['cantidad'];
      $fecha = $_POST['fecha'];
      if (!empty($codComercial) && !empty($refProducto) && !empty($cantidad) && !empty($fecha) && $cantidad > 0) {
        $base = "ventas_comerciales";
        $query = "update ventas set cantidad='$cantidad' where codComercial=$codComercial AND refProducto='$refProducto' AND fecha='$fecha'";
        operaciones($query, $base);
        echo "La venta ha sido actualizada";
      } else {
        echo "Rellena todos los campos y los números han de ser positivos";
      }
    }
    ?>

    <!-- FORMULARIO -->
    <form method="post" action="">
      <table width="25%" border="0" align="center" class="table">
        <tr>
          <td>Código comercial</td>
          <td><label for="codComercial"></label>
            <input type="text" name="codComercial" id="codComercial" value="<?php echo $codComercial; ?>" readonly>
          </td>
        </tr>
        <tr>
          <td>Referencia</td>
          <td><label for="refProducto"></label>
            <input type="text" name="refProducto" id="refProducto" value="<?php echo $refProducto; ?>" readonly>
          </td>
        </tr>
        <tr>
          <td>Cantidad</td>
          <td><label for="salario"></label>
            <input type="text" name="cantidad" id="cantidad" value="<?php echo $cantidad; ?>">
          </td>
        </tr>
        <tr>
          <td>Fecha</td>
          <td><label for="fecha"></label>
            <input type="text" name="fecha" id="fecha" value="<?php echo $fecha; ?>" readonly>
          </td>
        </tr>
        <tr>
          <td colspan="2"><input type="submit" name="actualizar" id="actualizar" value="Actualizar" class="btn btn-default"></td>
        </tr>
      </table>
    </form>

</body>

</html>