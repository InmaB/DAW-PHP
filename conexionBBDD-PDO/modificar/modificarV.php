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
    <h2>Modificar Venta</h2>

    <?php
    include '../config/misfunciones.php';

    //si existe actualizar, los guarda y realiza la operación
    if (isset($_POST['actualizar'])) {
      if (!empty($_POST['codComercial']) && !empty($_POST['refProducto']) && !empty($_POST['cantidad']) && !empty($_POST['fecha'])) {
        $codComercial = $_POST['codComercial'];
        $refProducto = $_POST['refProducto'];
        $cantidad = $_POST['cantidad'];
        $fecha = $_POST['fecha'];

        //conexion y se realiza la operacion
        $base = "ventas_comerciales";
        $query = "update ventas set cantidad='$cantidad', fecha='$fecha' where codComercial='$codComercial', refProducto='$refProducto'";
        operaciones($query, "ventas_comerciales");
        echo "La venta ha sido actualizada";
      }
    }

    $conexion = conectar("ventas_comerciales");
    $query = "select * from ventas";
    $registros = $conexion->query($query) or die($conexion->error);
    ?>

    <!--     FORMULARIO -->
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
      <table width="100%" border="0" align="center" class="table">
        <tr>
          <th>Código</th>
          <th>Referencia</th>
          <th>Cantidad</th>
          <th>Fecha</th>
        </tr>
        <?php
        while ($reg = $registros->fetch()) {
          //mostramos los registros
        ?>

          <tr>
            <td><?php echo $reg['codComercial']; ?></td>
            <td><?php echo $reg['refProducto']; ?></td>
            <td><?php echo $reg['cantidad']; ?></td>
            <td><?php echo $reg['fecha']; ?></td>


            <td><a href="formularioV.php?codComercial=<?php echo $reg['codComercial']; ?>&refProducto=<?php echo $reg['refProducto']; ?>&cantidad=<?php echo $reg['cantidad']; ?>&fecha=<?php echo $reg['fecha']; ?>">
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