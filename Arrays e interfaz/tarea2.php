<!DOCTYPE html>
<!--Inma Balbuena. Tarea 2-->
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tarea 2</title>
    <link rel="stylesheet" href="estilo/style.css">
</head>

<body>
    <h1>Lista de la compra</h1>

    <form name="formulario" action="tarea2.php" method="post">
        <?php

        include "funciones.php";
        //si la array no esta vacia
        if (!empty($_POST['listaCompras'])) {
            $array = explode(",", $_POST['listaCompras']); //pasa la cadena a array
            $pos = count($array);
        } else {
            $array = array(); //si no existe el array, se crea
            $pos = 0;
        }

        ///////////////
        // BOTÓN INSERTAR
        //////////////
        if (isset($_REQUEST['insertar'])) {
            //si el nombre no esta vacio se guarda la variable
            if (!empty($_POST['nombre'])) {
                $nombre = $_POST['nombre'];
                //se llama la función si existe
                $si = existe($array, $nombre);
                if (empty($_POST['cantidad'])) {
                    $cantidad = "0";
                } else {
                    $cantidad = $_POST['cantidad'];
                }

                if (empty($_POST['precio'])) {
                    $precio = "0";
                } else {
                    $precio = $_POST['precio'];
                }

                //si el nombre existe:
                if ($si || $si === 0) {
                    $array[$si + 1] = $cantidad;
                    $array[$si + 2] = $precio;
                } else {
                    //si no existe nombre se almacenará en la posición 0, se hará lo mismo con cantidad y precio
                    $array[$pos] = $nombre;
                    $array[$pos + 1] = $cantidad;
                    $array[$pos + 2] = $precio;
                    echo "<div class='info'>DATOS AÑADIDOS</div>";
                    mostrarTablaParcial($array);
                }
            } else {
                echo "<div class='info'>NOMBRE VACÍO, COMPLETA EL CAMPO</div>";
            }
        }

        ///////////////
        // BOTÓN MOSTRAR
        //////////////
        if (isset($_REQUEST['mostrar'])) {
            mostrarTabla($array);
        }

        ///////////////
        // BOTÓN ELIMINAR
        //////////////
        if (isset($_POST['eliminar'])) {
            if (!empty($_POST['nombre'])) {
                $nom = $_POST['nombre'];
                $si = existe($array, $nom);
                if ($si || $si === 0) {
                    unset($array[$si]);
                    unset($array[$si + 1]);
                    unset($array[$si + 2]);
                    $array = array_values($array); //reestructura el array
                    echo "<div class='info'>DATO ELIMINADO</div>";
                }
            } else {
                echo "<div class='info'>NO SE HA PODIDO ELIMINAR</div>";
            }
        }

        ///////////////
        // BOTÓN MODIFICAR
        //////////////
        if (isset($_POST['modificar'])) {
            echo ("<div class='info'>
              Teclea el nombre para modificar datos,<br> luego rellene los campos nombre, <br>cantidad y precio y pulse modificar
              </div>");

            // si existe nombre o no está vacío se recorrerá el array y se guardará el nuevo nombre con sus datos
            if (isset($_POST['nombre']) && (!empty([$_POST['nombre']]))) {
                for ($i = 0; $i < count($array); $i = $i + 3) {
                    if (($_POST['nombre'] == $array[$i])) {
                        if (!empty($_POST['nombre']))
                            $array[$i] = $_POST['nombre'];
                        if (!empty($_POST['cantidad']))
                            $array[$i + 1] = $_POST['cantidad'];
                        if (!empty($_POST['precio']))
                            $array[$i + 2] = $_POST['precio'];
                        echo ("<div class='info'>CAMBIO EFECTUADO</div>");
                    } else
                        echo ("");
                }

                mostrarTabla($array);
            } else {
                echo ("<div class='info'>EL PRODUCTO NO EXISTE</div>");
            }
        }


        ?>

        <label for="Nombre">Nombre:</label>
        <input type="text" name="nombre" value="">

        <label for="cantidad">Cantidad:</label>
        <input type="text" name="cantidad" value="">
        <label for="precio">Precio</label>
        <input type="text" name="precio" value="">

        <input name="listaCompras" type="hidden" value="<?php if (isset($array)) echo implode(",", $array); ?>">
        <input type="submit" name="mostrar" value="Mostrar lista">
        <input type="submit" name="insertar" value="Insertar">
        <input type="submit" name="modificar" value="Modificar">
        <input type="submit" name="eliminar" value="Eliminar">
    </form>


</body>

</html>