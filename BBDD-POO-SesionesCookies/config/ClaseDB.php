<?php
require_once("Anuncio.php");
require_once("Anunciante.php");
include "datosBD.php";

class ClaseDB
{


	// crear conexion
	public static function establecerConexion()
	{
		try {
			$conexion = new PDO(DNS, USER, PASSWORD); // crea una nueva conexión PDO utilizando DNS, usuario y contraseña
			$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // establece el modo de error en excepción
			$conexion->exec("SET CHARACTER SET UTF8"); // establece el conjunto de caracteres en UTF8
			return $conexion;
		} catch (PDOException $e) {
			die("Código: " . $e->getCode() . "<br>Error: " . $e->getMessage()); // si ocurre un error, muestra el código de error y el mensaje
		}
	}

	// obtener anuncios
	function obtenerAnuncios()
	{

		$con = $this->establecerConexion();
		$sql = "SELECT * FROM anuncios";
		$resultado = $con->query($sql);
		if ($resultado) {
			$lista = array();
			$row = $resultado->fetch();
			while ($row != null) {
				$lista[] = new Anuncio(" ", $row['autor'], $row['moroso'], $row['localidad'], $row['descripcion'], $row['fecha']);

				$row = $resultado->fetch();
			}
			return $lista;
		} else
			return false;
	}

	// insertar anuncios
	function insertarAnuncios($anuncio)
	{
		$con = $this->establecerConexion();
		$sql = "INSERT INTO anuncios (autor, moroso, localidad, descripcion, fecha) VALUES ('" . $anuncio->getAutor() . "', '" . $anuncio->getMoroso() . "', '" . $anuncio->getLocalidad() . "', '" . $anuncio->getDescripcion() . "', '" . $anuncio->getFecha() . "')";
		$resultado = $con->query($sql);
		unset($con);
		if ($resultado)
			return true;
		else
			return false;
	}

	// borrar anuncios
	function borrarAnuncios($autor, $moroso, $fecha)
	{
		$con = $this->establecerConexion();
		$sql = "DELETE FROM anuncios WHERE autor='$autor' AND moroso='$moroso' AND fecha='$fecha'";
		$resultado = $con->query($sql);
		unset($con);
		if ($resultado)
			return true;
		else
			return false;
	}

	// modificar anuncios
	function modificarAnuncios($autor, $moroso, $localidad, $descripcion, $fecha)
	{
		$con = $this->establecerConexion();
		$sql = "UPDATE anuncios SET localidad='$localidad', descripcion='$descripcion' WHERE autor='$autor' AND moroso='$moroso' AND fecha='$fecha'";
		$resultado = $con->query($sql);
		unset($con);
		if ($resultado)
			return true;
		else
			return false;
	}

	// obtiene el anunciante mediante su login
	function obtenerAnunciante($login)
	{
		$con = $this->establecerConexion();
		$sql = "SELECT * FROM anunciantes WHERE login='$login'";
		$resultado = $con->query($sql);
		$anunciante = $resultado->fetch();
		unset($con);
		$oAnunciante = new Anunciante($anunciante['login'], $anunciante['password'], $anunciante['bloqueado'], $anunciante['email']);
		return $oAnunciante;
	}

	// comprueba si existe anunciante
	function existeAnunciante($login)
	{
		$con = $this->establecerConexion();
		$sql = "SELECT * FROM anunciantes WHERE login='$login'";
		$resultado = $con->query($sql);
		$anunciante = $resultado->fetch();
		if ($anunciante == null)
			return false;
		else
			return true;
	}

	// comprueba si existe anuncio
	function existeAnuncio($login, $moroso, $fecha)
	{
		$con = $this->establecerConexion();
		$sql = "SELECT
			* FROM anuncios WHERE autor='$login' AND moroso='$moroso' AND fecha='$fecha'";
		$resultado = $con->query($sql);
		$anuncio = $resultado->fetch();
		if ($anuncio == null)
			return false;
		else
			return true;
	}

	// inserta Anunciante
	function insertarAnunciante($anunciante)
	{

		$user = $anunciante->getLogin();
		$pasw = $anunciante->getPassword();
		$lock = $anunciante->getBloqueado();
		$mail = $anunciante->getEmail();

		$sql = "INSERT INTO anunciantes (login, password, bloqueado, email) VALUES ('$user','$pasw',$lock,'$mail');";

		$con = $this->establecerConexion();
		$resultado = $con->query($sql);
		unset($con);
		if ($resultado) {
			return true;
		} else {
			echo ('entra en false');
			return false;
		}
	}

	// comprueba si existe email
	function existeMail($email)
	{
		$con = $this->establecerConexion();
		$sql = "SELECT * FROM anunciantes WHERE email='$email'";
		$resultado = $con->query($sql);
		$anunciante = $resultado->fetch();
		if ($anunciante == null)
			return false;
		else
			return true;
	}

	//consulta general
	function query($sql)
	{
		$con = $this->establecerConexion();
		$resultado = $con->query($sql);
		unset($con);
		echo ($resultado);
		return $resultado;
	}


	// muestra los bloqueados, representados con un 1
	function obtenerBloqueados()
	{
		$con = $this->establecerConexion();
		$sql = "SELECT * FROM anunciantes WHERE bloqueado=1";
		$resultado = $con->query($sql);
		$anunciante = $resultado->fetch();
		$lista = array();
		while ($anunciante != null) {
			$lista[] = new Anunciante($anunciante['login'], $anunciante['password'], $anunciante['bloqueado'], $anunciante['email']);
			$anunciante = $resultado->fetch();
		}
		return $lista;
	}

	// desbloquea a un usaurio poniendolo a 0
	function desbloquearUsuario($login)
	{
		$con = $this->establecerConexion();
		$sql = "UPDATE anunciantes SET bloqueado=0 WHERE login='$login'";
		$resultado = $con->query($sql);
		unset($con);
		if ($resultado)
			return true;
		else
			return false;
	}
}
