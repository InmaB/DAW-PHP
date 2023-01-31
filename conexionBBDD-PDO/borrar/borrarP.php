<?php
include '../config/misfunciones.php';

?>
<!-- BORRAR PRODUCTO -->
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Borrar Comercial</title>
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
        <h2>Borrar Producto</h2>
        <br>

        <!--  FORMULARIO -->
        <form id="form_seleccion" action="" method="post">
            <b>Producto: </b>
            <select name="borrarP">

                <?php
                //si existe borrar, borra lo productos
                if (isset($_POST['borrar'])) {
                    $query = "DELETE FROM productos WHERE referencia = '" . $_POST['borrarP'] . "'";
                    operaciones($query, "ventas_comerciales");
                    echo "El producto ha sido borrado";
                }
                if (isset($_POST['producto'])) $producto = $_POST['producto'];
                $base = conectar("ventas_comerciales");
                if (true) {
                    //desplegable
                    $sql = "SELECT referencia, nombre FROM productos";
                    $resultado = $base->query($sql);
                    if ($resultado) {
                        $row = $resultado->fetch();
                        while ($row != null) {
                            echo "<option value='${row['referencia']}'";
                            if (isset($producto) && $producto == $row['referencia'])
                                echo " selected='true'";
                            echo ">${row['nombre']}</option>";
                            $row = $resultado->fetch();
                        }
                        //cierre de conexión
                        unset($resultado);
                    }
                } else {
                    //mensaje si hay error
                    $mensaje = $base->connect_error;
                }

                ?>
            </select>
            <input type="submit" value="Borrar" name="borrar" class="btn btn-default">
        </form>
        <?php
        if (isset($_POST['borrar']))
            echo "El producto ha sido eliminado correctamente";
        ?>

</body>

</html>