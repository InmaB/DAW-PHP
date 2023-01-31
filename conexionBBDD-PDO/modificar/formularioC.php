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

  <!-- MENU -->
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
    <h2>Modificar Comercial</h2>
    <?php
    include '../config/misfunciones.php';
    //Si no existe actualizar lo coge
    if (!isset($_POST['actualizar'])) {
      $codigo = $_GET['codigo'];
      $nombre = $_GET['nombre'];
      $salario = $_GET['salario'];
      $hijos = $_GET['hijos'];
      $fNacimiento = $_GET['fNacimiento'];
    } else {
      $codigo = $_POST['codigo'];
      $nombre = $_POST['nombre'];
      $salario = $_POST['salario'];
      $hijos = $_POST['hijos'];
      $fNacimiento = $_POST['fNacimiento'];
      //si se quita !empty en hijos, funciona, porque vacío lo considera como valor 0
      //si se da estas condiciones se realiza la operación. AUNQUE EL VALOR 0 EN HIJOS NO LO GUARDA
      if (!empty($codigo) && !empty($nombre) && !empty($salario) && !empty($hijos) && !empty($fNacimiento) && $hijos >= 0 && $salario >= 0) {
        $base = "ventas_comerciales";
        $query = "update comerciales set nombre='$nombre',salario='$salario',hijos='$hijos', fNacimiento='$fNacimiento' where codigo=$codigo";
        operaciones($query, "ventas_comerciales");
        echo "El comercial ha sido actualizado";
      } else {
        echo "Rellena todos los campos y los números han de ser positivos";
      }
    }
    ?>

    <!-- FORMULARIO -->
    <form method="post" action="">
      <table width="25%" border="0" align="center" class="table">
        <tr>
          <td>Código</td>
          <td><label for="codigo"></label>
            <input type="text" name="codigo" id="codigo" value="<?php echo $codigo; ?>" readonly>
          </td>
        </tr>
        <tr>
          <td>Nombre</td>
          <td><label for="nombre"></label>
            <input type="text" name="nombre" id="nombre" value="<?php echo $nombre; ?>">
          </td>
        </tr>
        <tr>
          <td>Salario</td>
          <td><label for="salario"></label>
            <input type="number" name="salario" id="salario" value="<?php echo $salario; ?>">
          </td>
        </tr>
        <tr>
          <td>Hijos</td>
          <td><label for="hijos"></label>
            <input type="number" name="hijos" id="hijos" value="<?php echo $hijos; ?>">
          </td>
        </tr>
        <tr>
          <td>Fecha de nacimiento</td>
          <td><label for="fNacimiento"></label>
            <input type="date" min="1954-01-01" max="2004-12-31" name="fNacimiento" id="fNacimiento" value="<?php echo $fNacimiento; ?>">
          </td>
        </tr>
        <tr>
          <td colspan="2"><input type="submit" name="actualizar" id="actualizar" value="Actualizar" class="btn btn-default"></td>
        </tr>
      </table>
    </form>

</body>

</html>