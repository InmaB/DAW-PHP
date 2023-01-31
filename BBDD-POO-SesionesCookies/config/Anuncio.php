<?php
	class Anuncio {
		//Variables
		private $id_anuncio;
		private $autor;
		private $moroso;
		private $localidad;
		private $descripcion;
		private $fecha;

		//Constructor
		public function __construct($id_anuncio, $autor, $moroso, $localidad, $descripcion, $fecha) {
			$this->id_anuncio = $id_anuncio;
			$this->autor = $autor;
			$this->moroso = $moroso;
			$this->localidad = $localidad;
			$this->descripcion = $descripcion;
			$this->fecha = $fecha;
		}

		//Getters
		public function getId_anuncio() {
			return $this->id_anuncio;
		}

		public function getAutor() {
			return $this->autor;
		}

		public function getMoroso() {
			return $this->moroso;
		}

		public function getLocalidad() {
			return $this->localidad;
		}

		public function getDescripcion() {
			return $this->descripcion;
		}

		public function getFecha() {
			return $this->fecha;
		}

		//Setters
		public function setId_anuncio($id_anuncio) {
			$this->id_anuncio = $id_anuncio;
		}

		public function setAutor($autor) {
			$this->autor = $autor;
		}

		public function setMoroso($moroso) {
			$this->moroso = $moroso;
		}

		public function setLocalidad($localidad) {
			$this->localidad = $localidad;
		}

		public function setDescripcion($descripcion) {
			$this->descripcion = $descripcion;
		}

		public function setFecha($fecha) {
			$this->fecha = $fecha;
		}
	}
?>