<?php
//Validaciones

/*
Comprueba todos las funciones mas pequeñas en una unica, obteniendo el usuario la contraseña introducida y la de BD
Si existiera algun error lo devuelve de lo contrario estara vacio
*/
function comprueba_datos($password, $password2, $email)
{
    $error = "";

    if (strcmp($password, $password2) != 0)
        $error .= "Las contraseñas deben ser iguales.<br>";
    if (strlen($password) > 8)
        $error .= "La contraseña debe tener un maximo de 8 caracteres.<br>";
    if (!comprueba_tamanio_contrasenia($password))
        $error .= "La contraseña debe tener un mínimo de 6 caracteres.<br>";
    if (!comprueba_minus_contrasenia($password))
        $error .= "La contraseña debe tener al menos una letra minúscula.<br>";
    if (!comprueba_mayus_contrasenia($password))
        $error .= "La contraseña debe tener al menos una letra mayúscula.<br>";
    if (!comprueba_num_contrasenia($password))
        $error .= "La contraseña debe tener al menos un número.<br>";
    if (!check_email($email))
        $error .= "El email introducido no es válido.<br>";

    return $error;
}

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
}


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
}

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
}

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
}


/*
 * Función para comprobar si un email es válido
 * Recibimos una variable por referencia donde guardamos el error cometido por el usuario
 * Devolvemos un valor booleano true si es válido y false en caso contrario
 */
function check_email($email)
{
    if (preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $email)) {
        return true;
    } else {
        return false;
    }
}

//Bloque visualizar
/*
 * Función para consultar todos los anuncios del foro.
 * Imprimimos por pantalla los anuncios
 */
function consulta_full_anuncios($anuncios)
{
    try {

        if ($anuncios) {
            // Mostramos los datos
            foreach ($anuncios as $anuncio) {
                if ($anuncio->getFecha() >= date('Y-m-d', time() - 604800)) {
                    //El anuncio es Nuevo
                    echo "<div class='post_privado'>";
                } else {
                    //El anuncio es antiguo
                    echo "<div class='anuncio_publico'>";
                }
                echo "<div class='autoryfecha'><span style='color:#528FD5'>" . $anuncio->getAutor() . "</span>&nbsp;&nbsp;&nbsp;publicó el&nbsp;&nbsp;&nbsp;<span style='color:#528FD5'>"
                    . formatea_fecha($anuncio->getFecha()) . "</span></div>";
                echo "<div class='contenido'>" . $anuncio->getDescripcion() . "</div>";
                echo "<div class='localidad'>Localidad: " . $anuncio->getLocalidad() . "</div>";
                echo "<div class='moroso'>Moroso: " . $anuncio->getMoroso() . "</div>";
                echo "</div>";
            }
        }
    } catch (PDOException $e) {
        $error = $e->getCode();
        $anuncio = $e->getMessage();
        die("Error: " . $anuncio . " " . $error);
    }
}

/*
 * Función con la que damos formato a una fecha
 * El formato de salida será dd/mm/aaaa
 * Devolvemos un string con el formato indicado
 */
function formatea_fecha($fecha1)
{

    $fecha2 = date("d-m-Y", strtotime($fecha1));

    return $fecha2;
}
