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
    <h2>Modificar Producto</h2>
    <?php
    include '../config/misfunciones.php';
    //Si no existe actualizar lo coge
    if (!isset($_POST['actualizar'])) {
      $referencia = $_GET['referencia'];
      $nombre = $_GET['nombre'];
      $descripcion = $_GET['descripcion'];
      $precio = $_GET['precio'];
      $descuento = $_GET['descuento'];
    } else {
      $referencia = $_POST['referencia'];
      $nombre = $_POST['nombre'];
      $descripcion = $_POST['descripcion'];
      $precio = $_POST['precio'];
      $descuento = $_POST['descuento'];
      if (!empty($referencia) && !empty($nombre) && !empty($descripcion) && !empty($precio) && !empty($descuento) && $precio > 0 && $descuento >= 0) {
        $base = "ventas_comerciales";
        $query = "update productos set nombre='$nombre',descripcion='$descripcion',precio='$precio', descuento='$descuento' where referencia='$referencia'";
        operaciones($query, "ventas_comerciales");
        echo "El producto ha sido actualizado";
      } else {
        echo "Rellena todos los campos y los números han de ser positivos";
      }
    }
    ?>

    <!--    FORMULARIO -->
    <form method="post" action="">
      <table width="25%" border="0" align="center" class="table">
        <tr>
          <td>Referencia</td>
          <td><label for="referencia"></label>
            <input type="text" name="referencia" id="referencia" value="<?php echo $referencia; ?>" readonly>
          </td>
        </tr>
        <tr>
          <td>Nombre</td>
          <td><label for="nombre"></label>
            <input type="text" name="nombre" id="nombre" value="<?php echo $nombre; ?>">
          </td>
        </tr>
        <tr>
          <td>Descripcion</td>
          <td><label for="salario"></label>
            <input type="text" name="descripcion" id="descripcion" value="<?php echo $descripcion; ?>">
          </td>
        </tr>
        <tr>
          <td>Precio</td>
          <td><label for="precio"></label>
            <input type="text" name="precio" id="precio" value="<?php echo $precio; ?>">
          </td>
        </tr>
        <tr>
          <td>Descuento</td>
          <td><label for="fNacimiento"></label>
            <input type="text" name="descuento" id="descuento" value="<?php echo $descuento; ?>">
          </td>
        </tr>
        <tr>
          <td colspan="2"><input type="submit" name="actualizar" id="actualizar" value="Actualizar" class="btn btn-default"></td>
        </tr>
      </table>
    </form>

</body>

</html>