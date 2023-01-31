<?php

/*Inma Balbuena. Tarea 2, funciones */

function existe($array, $nombre)
{
    //si encuentra el nombre en la array nos devuelve la posicion donde se encuentra el elemento
    $posicion = array_search($nombre, $array, false);
    return $posicion;
}

function calcular_Precio_Total_Producto($precio, $cantidad)
{
    return ($precio * $cantidad);
}

function Calcular_Precio_Total_Compra($totalPrecios)
{
    $suma = 0;
    foreach ($totalPrecios as $precios) {
        $suma = $suma + $precios;
    }
    return $suma;
}


// se muestra nombre, cantidad y precio
function mostrarTablaParcial($array)
{
    if (count($array) > 1) {
        echo "<table><tr align='center'><th>Nombre</th><th>Cantidad</th><th>Precio</th></tr>";
        //recorremos el array
        for ($i = 0; $i < count($array); $i += 3) {
            if ($array[$i] !== NULL)
                echo "<tr><td>" . $array[$i] . "</td><td>" . $array[$i + 1] . "</td><td>" . $array[$i + 2] . "</td></tr>";
        }
        echo "</table>";
    }
}

// se muestra la tabla completa, junto con los cálculos
function mostrarTabla($array)
{
    $precios = array();

    if (count($array) > 1) {
        echo "<table><tr align='center'><th>Nombre</th><th>Cantidad</th><th>Precio</th><th>Total</th></tr>";
        //recorremos el array y mostramos
        for ($i = 0; $i < count($array); $i += 3) {
            if ($array[$i] !== NULL)
                echo "<tr><td>" . $array[$i] . "</td><td>" . $array[$i + 1] . "</td><td>" . $array[$i + 2] . "</td>" . "<td>" . calcular_Precio_Total_Producto($array[$i + 1], $array[$i + 2]) . "</td></tr>";
            //creamos un array para que aquí se vaya almacenando los totales
            $precios[] = calcular_Precio_Total_Producto($array[$i + 1], $array[$i + 2]);
        }
        echo "<tr><td colspan='3'><b>TOTAL:</b></td><td><b>" . Calcular_Precio_Total_Compra($precios) . "</b></td></tr>";
        echo "</table>";
    }
}
