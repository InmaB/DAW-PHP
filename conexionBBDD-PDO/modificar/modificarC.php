<!DOCTYPE html>
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
    //insertar datos
    if (isset($_POST['actualizar'])) {
      if (!empty($_POST['codigo']) && !empty($_POST['nombre']) && !empty($_POST['salario']) && !empty($_POST['hijos']) && !empty($_POST['fNacimiento'])) {
        $codigo = $_POST['codigo'];
        $nombre = $_POST['nombre'];
        $salario = $_POST['salario'];
        $hijos = $_POST['hijos'];
        $fNacimiento = $_POST['fNacimiento'];

        //conexion y se realiza la operacion
        $base = "ventas_comerciales";
        $query = "update comerciales set nombre='$nombre',salario='$salario',hijos='$hijos', fNacimiento='$fNacimiento' where codigo=$codigo";
        operaciones($query, "ventas_comerciales");
      }
    }

    $conexion = conectar("ventas_comerciales");
    $query = "select * from comerciales";
    $registros = $conexion->query($query) or die($conexion->error);
    ?>

    <!-- FORMULARIO -->
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
      <table width="100%" border="0" align="center" class="table">
        <tr>
          <th>Código</th>
          <th>Nombre</th>
          <th>Salario</th>
          <th>Hijos</td>
          <th>Fecha de Nacimiento</th>
        </tr>
        <?php
        while ($reg = $registros->fetch()) {
          //los mostrará en la siguiente tabla
        ?>

          <tr>
            <td><?php echo $reg['codigo']; ?></td>
            <td><?php echo $reg['nombre']; ?></td>
            <td><?php echo $reg['salario']; ?></td>
            <td><?php echo $reg['hijos']; ?></td>
            <td><?php echo $reg['fNacimiento']; ?></td>

            <td class='bot'><a href="formularioC.php?codigo=<?php echo $reg['codigo']; ?>&nombre=<?php echo $reg['nombre']; ?>&salario=<?php echo $reg['salario']; ?>&hijos=<?php echo $reg['hijos']; ?>&fNacimiento=<?php echo $reg['fNacimiento']; ?>">
                <input type='button' name='actualizar' value='Actualizar' class="btn btn-default"></a></td>
          </tr>
        <?php

        }
        unset($registros);
        ?>

      </table>
    </form>
</body>

</html>