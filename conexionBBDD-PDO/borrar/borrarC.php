<?php
include '../config/misfunciones.php';

?>
<!-- BORRAR COMERCIALES -->
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
        <h2>Borrar Comercial</h2>
        <br>

        <!-- FORMULARIO -->
        <form id="form_seleccion" action="" method="post">
            <b>Comercial: </b>
            <select name="borrarComercial">

                <?php
                //si existe borrarComercial borrará los comerciales con el codigo indicado
                if (isset($_POST['borrarComercial'])) {
                    echo $_POST['borrar'];
                    $query = "DELETE FROM comerciales WHERE codigo = '" . $_POST['borrarComercial'] . "'";
                    operaciones($query, "ventas_comerciales");
                }
                // selección del desplegable para elegir a quién borrar
                if (isset($_POST['comercial'])) $comercial = $_POST['comercial'];
                $base = conectar("ventas_comerciales");
                if (true) {
                    $sql = "SELECT codigo,nombre FROM comerciales";
                    $resultado = $base->query($sql);
                    if ($resultado) {
                        $row = $resultado->fetch();
                        while ($row != null) {
                            echo "<option value='${row['codigo']}'";
                            if (isset($comercial) && $comercial == $row['codigo'])
                                echo " selected='true'";
                            echo ">${row['nombre']}</option>";
                            $row = $resultado->fetch();
                        }
                        unset($resultado);
                    }
                } else {
                    $mensaje = $base->connect_error;
                }


                ?>
            </select>

            <input type="submit" name="submit" value="Borrar" class="btn btn-default" />
        </form>
        <?php
        if (isset($_POST['submit'])) {
            echo "El comercial ha sido eliminado exitosamente";
        }
        ?>

</body>

</html>