<?php

include '../config/misfunciones.php';

$codigoErr = $nombreErr = $salarioErr = $hijosErr = $fNacimientoErr = "";

//Asignar valores a las variables
if (isset($_REQUEST['codigo'])) {
    $codigo = $_REQUEST['codigo'];
} else {
    $codigo = "";
}
if (isset($_REQUEST['nombre'])) {
    $nombre = $_REQUEST['nombre'];
} else {
    $nombre = "";
}
if (isset($_REQUEST['salario'])) {
    $salario = $_REQUEST['salario'];
} else {
    $salario = "";
}
if (isset($_REQUEST['hijos'])) {
    $hijos = $_REQUEST['hijos'];
} else {
    $hijos = "";
}
if (isset($_REQUEST['fNacimiento'])) {
    $fNacimiento = $_REQUEST['fNacimiento'];
} else {
    $fNacimiento = "";
}

//si no existe
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //si está vacío el campo de código o no es numérico (máximo 3 digitos) salta el error, convertir a entero
    if (empty($_POST["codigo"]) || !is_numeric($_POST["codigo"]) || strlen($_POST["codigo"]) > 3) {
        $codigoErr = "Código incorrecto, debe ser numérico y máximo 3 dígitos";
    } else {
        $codigo = test_input($_POST["codigo"]);
    }

    //si está vacio el campo o el nombre tiene números o caracteres especiales salta el error
    if (empty($_POST["nombre"]) || !preg_match("/^[a-zA-Z ]*$/", $_POST["nombre"])) {
        $nombreErr = "Nombre incorrecto, debe contener sólo letras y espacios";
    } else {
        $nombre = test_input($_POST["nombre"]);
    }

    //si el campo está vacío o no numero o es menor de 0 salta el error
    if (empty($_POST["salario"]) || !is_numeric($_POST["salario"]) || $_POST["salario"] < 0) {
        $salarioErr = "Salario incorrecto, debe ser numérico y mayor que 0";
    } else {
        $salario = test_input($_POST["salario"]);
    }

    //si el numero es 0 lo guarda, si es inferior a 0 o el campo está vacío salta el error
    if (empty($_POST["hijos"]) && $_POST["hijos"] == 0) {
        $hijos = 0;
    } else {
        $hijosErr = "Introduce el numero de hijos";
    }

    if (empty($_POST["fNacimiento"])) {
        $fNacimientoErr = "Introduce tu fecha de nacimiento";
    } else {
        $fNacimiento = $_POST["fNacimiento"];
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
        <h2>Insertar Comercial</h2>

        <!-- FORMULARIO -->
        <form method="post" class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label class="control-label col-sm-2" for="codigo">Código:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" placeholder="Introduce el codigo" name="codigo" value="<?php echo $codigo; ?>" autofocus>
                </div>
                <span class="error"><?php echo $codigoErr;  ?> </span>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="nombre">Nombre:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" placeholder="Introduce el nombre" name="nombre" value="<?php echo $nombre; ?>">
                </div>
                <span class="error"><?php echo $nombreErr;  ?> </span>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="salario">Salario:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" placeholder="Introduce el salario" name="salario" value="<?php echo $salario; ?>">
                </div>
                <span class="error"><?php echo $salarioErr;  ?> </span>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="hijos">Hijos:</label>
                <div class="col-sm-10">
                    <!-- tipo input numeric en hijos, controlamos arriba que si es 0 lo guarde y no lo considere como vacío -->
                    <input type="number" class="form-control" placeholder="Introduce el numero de hijos" name="hijos" value="<?php echo $hijos; ?>">
                </div>
                <span class="error"><?php echo $hijosErr;  ?> </span>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="fNacimiento">Fecha de Nacimiento:</label>
                <div class="col-sm-10">
                    <!-- La fecha de nacimiento tendrá ese minimo y maximo que será la edad correspondiente de un trabajador -->
                    <input type="date" class="form-control" min="1954-01-01" max="2004-12-31" placeholder="Introduce la fecha de nacimiento" name="fNacimiento" value="<?php echo $fNacimiento; ?>">
                </div>
                <span class="error"><?php echo $fNacimientoErr;  ?> </span>
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
    if (($_SERVER["REQUEST_METHOD"] == "POST") && ($codigoErr == "") && ($nombreErr == "") && ($salarioErr == "") && ($hijosErr == "") && ($fNacimientoErr == "")) {
        $query = "insert into comerciales(codigo, nombre, salario, hijos, fNacimiento)values('$codigo','$nombre','$salario','$hijos','$fNacimiento')";
        $bd = "ventas_comerciales";
        operaciones($query, $bd);
        echo "El comercial fue dado de alta";
    }
    ?>

</body>

</html>