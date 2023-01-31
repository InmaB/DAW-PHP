<?php

//funcion que comprueba los campos que no haya caracteres especiales, ni demasiados espacios en blanco...
function test_input($data)
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

function conectar($base)
{
  try {
    $conexion = new PDO("mysql:host=localhost;dbname=$base", "dwes", "dwes");
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conexion->exec("SET CHARACTER SET UTF8");
  } catch (PDOException $e) {
    die("Codigo: " . $e->getCode() . "<br>Error: " . $e->getMessage());
  } finally {
    return $conexion;
  }
}


function operaciones($query, $base)
{
  try {
    $conexion = conectar($base);
    $conexion->exec($query);
  } catch (PDOException $e) {
    die("Codigo: " . $e->getCode() . "<br>Error: " . $e->getMessage());
  } finally {
    $conexion = null;
  }
}

//devuelve los registros encontrados
function getRegistros($query, $base)
{
  try {
    $conexion = conectar($base);
    $registros = $conexion->query($query);
    return $registros;
  } catch (PDOException $e) {
    die("Codigo: " . $e->getCode() . "<br>Error: " . $e->getMessage());
  } finally {
    $conexion = null;
  }
}
