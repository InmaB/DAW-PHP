<?php
include "../config/misfunciones.php";
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title>Borrar Venta</title>
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
      <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
          Modificar <span class="caret"></span></a>
        <ul class="dropdown-menu" role="menu">
          <li><a href="../modificar/modificarC.php">Modificar Comerciales</a></li>
          <li><a href="../modificar/modificarP.php">Modificar Productos</a></li>
          <li><a href="../modificar/modificarV.php">Modificar Ventas</a></li>
        </ul>
      </li>
      <li class="dropdown active">
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
    <h2>Borrar Venta</h2>
    <br>

    <!-- FORMULARIO -->
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
      <table width="90%" border="0" align="center" class="table">
        <tr>
          <th>Código del comercial</th>
          <th>Referencia del producto</th>
          <th>Cantidad</th>
          <th>Fecha</th>

        </tr>
        <?php
        //si existe el botón del, eliminará ventas
        if (isset($_POST['del'])) {
          $referencia = $_REQUEST["refProducto"];
          $codigo = $_REQUEST["codComercial"];
          $cantidad = $_REQUEST["cantidad"];
          $fecha = $_REQUEST["fecha"];
          $sql = "delete from ventas where codComercial='$codigo' and refProducto='$referencia'and fecha='$fecha'";
          operaciones($sql, "ventas_comerciales");
          echo "La venta ha sido eliminada correctamente";
        }

        $conexion = conectar("ventas_comerciales");
        $query = "select * from ventas";

        $registros = $conexion->query($query) or die($conexion->error);
        while ($reg = $registros->fetch()) {
        ?>

          <!-- tabla que muestra los registros -->
          <tr>
            <td><?php echo $reg['codComercial']; ?></td>
            <td><?php echo $reg['refProducto']; ?></td>
            <td><?php echo $reg['cantidad']; ?></td>
            <td><?php echo $reg['fecha']; ?></td>

            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
              <td><input type='submit' name='del' value='Borrar' class="btn btn-default"></td>
              <!-- guarda los otros valores -->
              <td><input type='hidden' name='refProducto' value='<?php echo $reg['refProducto']; ?>'></td>
              <td><input type='hidden' name='codComercial' value='<?php echo $reg['codComercial']; ?>'></td>
              <td><input type='hidden' name='cantidad' value='<?php echo $reg['cantidad']; ?>'></td>
              <td><input type='hidden' name='fecha' value='<?php echo $reg['fecha']; ?>'></td>

          </tr>
    </form>


    </tr>
  <?php
        }
        //cierre conexión
        unset($conexion);
  ?>
  </table>
  </form>


</body>

</html>