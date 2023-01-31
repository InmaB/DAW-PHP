<?php
/*
 * Función para conectarnos a la BD
 * Para que no tengamos problemas con los acentos, en la cadena de conexión indicamos en el array de opciones la codificación
 * Devolvemos el identificador de la conexión
 */
function conexion_bd($base)
{
    try {
        $opc = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
        $dsn = "mysql:host=localhost;dbname=$base";
        $con = new PDO($dsn, "root", "", $opc);
        return $con;
    } catch (PDOException $e) {
        $error = $e->getCode();
        $anuncio = $e->getMessage();
        die("Error" . $anuncio . " " . $error);
    }
} //fin de conexion_bd

/*
 * Dado un login de usuario obtenemos su password
 *
 */
function obtener_password($login, $con)
{
    try {
        $sql = "Select password from usuarios where login='$login'";
        if ($resultado = $con->query($sql)) {
            $fila = $resultado->fetch();
            if ($fila != null) {
                unset($resultado);
                return $fila['password'];
            }
        }
    } catch (PDOException $e) {
        $error = $e->getCode();
        $anuncio = $e->getMessage();
        die("Error" . $anuncio . " " . $error);
    }
} //fin de obtener_password

/*
 * Comprobamos si existe el login en la BD
 * Devolvemos true si existe, false en caso contrario
 */
function existe_login($login, $con)
{
    try {
        $sql = "Select login from usuarios where login='$login'";
        if ($resultado = $con->query($sql)) {
            $fila = $resultado->fetch();
            unset($resultado);
            if ($fila != null) {
                return true;
            } else {
                return false;
            }
        }
    } catch (PDOException $e) {
        $error = $e->getCode();
        $anuncio = $e->getMessage();
        die("Error" . $anuncio . " " . $error);
    }
} //fin existe_login


/*
 * Función para comprobar si la contraseña tiene 6 o más caracteres
 * Devuelve true si el tamaño es igual o mayor a 6, false si el tamaño es menor a 6
 */
function comprueba_tamanio_contrasenia($contrasenia)
{
    if (strlen($contrasenia) < 6)
        return false;
    else
        return true;
} //fin de comprueba_tamanio_contrasenia


/*
 * Función para comprobar  si la contraseña tiene al menos una letra minúscula
 * Devuelve true si tiene al menos una minúscula y false en caso contrario
 */
function comprueba_minus_contrasenia($contrasenia)
{
    if (!preg_match('`[a-z]`', $contrasenia))
        return false;
    else
        return true;
} //fin de comprueba_minus_contrasenia

/*
 * Función para comprobar  si la contraseña tiene al menos una letra mayúscula
 * Devuelve true si tiene al menos una mayúscula y false en caso contrario
 */
function comprueba_mayus_contrasenia($contrasenia)
{
    if (!preg_match('`[A-Z]`', $contrasenia))
        return false;
    else
        return true;
} //fin de comprueba_mayus_contrasenia

/*
 * Función para comprobar  si la contraseña tiene al menos un caracter numérico
 * Devuelve true si tiene al menos un número y false en caso contrario
 */
function comprueba_num_contrasenia($contrasenia)
{
    if (!preg_match('`[0-9]`', $contrasenia))
        return false;
    else
        return true;
} //fin de comprueba_mayus_contrasenia


/*
 * Insertar los datos de un usuario en la BD
 * Devuelve true si la inserción se realizó y false en caso contrario
 */
function inserta_usuario($login, $password, $nombre, $fNacimiento, $presupuesto, $con)
{
    try {
        $password_hast = crypt($password, 'XC');
        $sql = "Insert into usuarios values ('$login','$password_hast','$nombre',$fNacimiento,'$presupuesto')";
        if ($con->exec($sql)) {
            return true;
        }
    } catch (PDOException $e) {
        $error = $e->getCode();
        $anuncio = $e->getMessage();
        die("Error" . $anuncio . " " . $error);
        return false;
    }
}

/*
 * Formatea fecha de formato yyyy-mm-dd a dd-mm-yyyy
 */
function formatea_fecha($fecha1)
{

    $fecha2 = date("d-m-Y", strtotime($fecha1));

    return $fecha2;
} //fin de formatea_fecha


//Operaciones para borrado o actualización de datos
function operaciones($query, $base)
{
    try {
        $conexion = conexion_bd($base);
        $conexion->exec($query);
    } catch (PDOException $e) {
        die("Codigo: " . $e->getCode() . "<br>Error: " . $e->getMessage());
    } finally {
        $conexion = null;
    }
}

//consigue los reguistros de una consulta
function getRegistros($query, $base)
{
    try {
        $conexion = conexion_bd($base);
        $registros = $conexion->query($query);
        $reg = $registros->fetch();
        return $reg;
    } catch (PDOException $e) {
        die("Codigo: " . $e->getCode() . "<br>Error: " . $e->getMessage());
    } finally {
        $conexion = null;
    }
}

function existsMov($bytes, $base)
{
    try {
        $conexion = conexion_bd($base);
        $query = "SELECT * FROM movimientos WHERE codigoMov = '$bytes'";
        $registros = $conexion->query($query);
        $reg = $registros->fetch();
        if ($reg) {
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        die("Codigo: " . $e->getCode() . "<br>Error: " . $e->getMessage());
    } finally {
        $conexion = null;
    }
}

function getSaldo($login, $fecha, $idMov)
{
    try {
        $con = conexion_bd("conta2");
        $consulta = $con->query("SELECT SUM(cantidad) FROM movimientos WHERE fecha<='" . $fecha . "' and codigoMov<='" . $idMov . "' and loginUsu='" . $login . "'");
        $saldo = $consulta->fetch();
        $consulta = $con->query("SELECT SUM(cantidad) FROM movimientos WHERE fecha<'" . $fecha . "' and codigoMov>='" . $idMov . "' and loginUsu='" . $login . "'");
        $saldo2 = $consulta->fetch();
        $saldo[0] += $saldo2[0];
        return $saldo[0];
    } catch (PDOException $e) {
        return false;
    }
}

//consigue los movimientos de un usuario por orden de fecha
function getMovimientos($login)
{
    $conexion = conexion_bd("conta2");
    $consulta = $conexion->prepare("SELECT * FROM movimientos WHERE loginUsu = '$login' ORDER BY fecha ASC");

    $consulta->execute();
    $movimientos = $consulta->fetchAll(PDO::FETCH_ASSOC);
    return $movimientos;
}

//selecciona los usuarios de la base de datos
function selectUsuario()
{
    $base = conexion_bd("conta2");
    if (true) {
        $sql = "SELECT login FROM usuarios";
        $resultado = $base->query($sql);
        if ($resultado) {
            $row = $resultado->fetch();
            while ($row != null) {
                echo "<option value='${row['login']}'";
                if (isset($usuario) && $usuario == $row['login'])
                    echo " selected='true'";
                echo ">${row['login']}</option>";
                $row = $resultado->fetch();
            }
            unset($resultado);
        }
    } else {
        $mensaje = $base->connect_error;
    }
}

//Asigna un codigo de movimiento
function codigo_movimento($login)
{
    try {
        $conexion = conexion_bd("conta2");
        $sql = "SELECT MAX(codigoMov) FROM movimientos  WHERE loginUsu='$login'";
        $result = $conexion->query($sql);
        $total = $result->fetchColumn();
        if ($total == 0)
            return 1;
        else
            return $total + 1;
    } catch (PDOException $e) {
        $error = "#" . $e->getCode() . ": " . $e->getMessage();
        return $error;
    }
}

//funcion que inserta movimiento en la base de datos
function inserta_movimiento($codigo, $login, $fecha, $concepto, $cantidad)
{
    try {
        $conexion = conexion_bd("conta2");
        $sql = "INSERT INTO movimientos VALUES ('$codigo', '$login', '$fecha', '$concepto', '$cantidad')";
        if ($conexion->exec($sql) == 1) {
            return true;
        }
    } catch (PDOException $e) {
        $error = "#" . $e->getCode() . ": " . $e->getMessage();
        return $error;
    }
}

function borrar_usuario($login)
{
    try {
        //borra los movimientos del usuario
        $sql = "create or replace trigger borrar_usuario before delete on usuarios for each row begin delete from movimientos where loginUsu=old.login; end ; ";
        actualizar($sql);

        //borra el usuario
        $conexion = conexion_bd("conta2");
        $sql2 = "DELETE FROM usuarios WHERE login='$login'";
        if ($conexion->exec($sql2) == 1) {
            return true;
        }
    } catch (PDOException $e) {
        $error = "#" . $e->getCode() . ": " . $e->getMessage();
        return $error;
    }
}

//actualiza la tabla de movimientos
function actualizar($sql)
{
    try {
        $conexion = conexion_bd("conta2");
        $resultado = $conexion->exec($sql);
        if ($resultado) {
            return true;
        }
        return false;
    } catch (PDOException $e) {
        $error = "#" . $e->getCode() . ": " . $e->getMessage();
        return $error;
    }
}
