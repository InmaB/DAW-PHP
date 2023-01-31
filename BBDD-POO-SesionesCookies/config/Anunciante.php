<?php
	class Anunciante {
		//Variables
		private $login;
		private $password;
		private $bloqueado;
		private $email;

		//Constructor
		public function __construct($login, $password, $bloqueado, $email) {
			$this->login = $login;
			$this->password = $password;
			$this->bloqueado = $bloqueado;
			$this->email = $email;
		}

		//Getters
		public function getLogin() {
			return $this->login;
		}

		public function getPassword() {
			return $this->password;
		}

		public function getBloqueado() {
			return $this->bloqueado;
		}

		public function getEmail() {
			return $this->email;
		}

		//Setters
		public function setLogin($login) {
			$this->login = $login;
		}

		public function setPassword($password) {
			$this->password = $password;
		}

		public function setBloqueado($bloqueado) {
			$this->bloqueado = $bloqueado;
		}

		public function setEmail($email) {
			$this->email = $email;
		}
	}
?>