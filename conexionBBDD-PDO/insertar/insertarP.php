<?php
//referencia, nombre, descripcion, precio, descuento
include '../config/misfunciones.php';

$referenciaErr = $nombreErr = $descripcionErr = $precioErr = $descuentoErr = "";
//Asignar valores a las variables
if (isset($_REQUEST['referencia'])) {
    $referencia = $_REQUEST['referencia'];
} else {
    $referencia = "";
}
if (isset($_REQUEST['nombre'])) {
    $nombre = $_REQUEST['nombre'];
} else {
    $nombre = "";
}
if (isset($_REQUEST['descripcion'])) {
    $descripcion = $_REQUEST['descripcion'];
} else {
    $descripcion = "";
}
if (isset($_REQUEST['precio'])) {
    $precio = $_REQUEST['precio'];
} else {
    $precio = "";
}
if (isset($_REQUEST['descuento'])) {
    $descuento = $_REQUEST['descuento'];
} else {
    $descuento = "";
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //si no existe

    //si está vacío el campo de referencia no empieza por 2 letras, resto números, máximo 6 salta el error
    if (empty($_POST["referencia"]) || !preg_match("/^[a-zA-Z]{2}[0-9]{4}$/", $_POST["referencia"])) {
        $referenciaErr = "Referencia incorrecta, debe contener 2 letras al principio y 4 números";
    } else {
        $referencia = test_input($_POST["referencia"]);
    }

    //si está vacio el campo o el nombre tiene números o caracteres especiales salta el error
    if (empty($_POST["nombre"]) || !preg_match("/^[a-zA-Z ]*$/", $_POST["nombre"])) {
        $nombreErr = "Nombre incorrecto, debe contener sólo letras y espacios";
    } else {
        $nombre = test_input($_POST["nombre"]);
    }

    if (empty($_POST["descripcion"])) {
        $descripcionErr = "Introduce la descripcion del producto";
    } else {
        $descripcion = $_POST["descripcion"];
    }

    //si el campo está vacío o no numero o es menor de 0 salta el error
    if (empty($_POST["precio"]) || !is_numeric($_POST["precio"]) || $_POST["precio"] < 0) {
        $precioErr = "Precio incorrecto, debe ser numérico y mayor que 0";
    } else {
        $precio = test_input($_POST["precio"]);
    }

    //si el campo está vacío o no numero o es menor de 0 salta el error
    if (empty($_POST["descuento"]) || !is_numeric($_POST["descuento"]) || $_POST["descuento"] < 0) {
        $descuentoErr = "Descuento incorrecto, debe ser numérico y mayor que 0";
    } else {
        $descuento = test_input($_POST["descuento"]);
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
        <h2>Insertar Producto</h2>

        <!-- FORMULARIO -->
        <form method="post" class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label class="control-label col-sm-2" for="referencia">Referencia:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" placeholder="Introduce la referencia" name="referencia" value="<?php echo $referencia; ?>">
                    <span class="error"><?php echo $referenciaErr; ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="nombre">Nombre:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" placeholder="Introduce el nombre" name="nombre" value="<?php echo $nombre; ?>">
                    <span class="error"><?php echo $nombreErr; ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="descripcion">Descripción:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" placeholder="Introduce la descripción" name="descripcion" value="<?php echo $descripcion; ?>"></input>
                    <span class="error"><?php echo $descripcionErr; ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="precio">Precio:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" placeholder="Introduce el precio" name="precio" value="<?php echo $precio; ?>">
                    <span class="error"><?php echo $precioErr; ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="descuento">Descuento:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" placeholder="Introduce el descuento" name="descuento" value="<?php echo $descuento; ?>">
                    <span class="error"><?php echo $descuentoErr; ?></span>
                </div>
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
    if (($_SERVER["REQUEST_METHOD"] == "POST") && ($referenciaErr == "") && ($nombreErr == "") && ($descripcionErr == "") && ($precioErr == "") && ($descuentoErr == "")) {
        $query = "insert into productos(referencia, nombre, descripcion, precio, descuento)values('$referencia','$nombre','$descripcion','$precio','$descuento')";
        $bd = "ventas_comerciales";
        operaciones($query, $bd);
        echo "El producto ha sido añadido satisfactoriamente";
    }
    ?>

</body>

</html>