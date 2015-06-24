<pre>
<?php
	class Vehiculo{
		public $matricula;
		private $color;
		protected $encendido;

		public function encender(){
			$this->encendido = true;
			echo "Vehiculo encendido <br />";
		}
$
		public function apagar(){
			$this->encendido = false;
			echo "Vehiculo apagado <br />";
		}
	}

	class Camion extends Vehiculo{
		
		private $carga;

		public function cargar($cantidad_a_cargar){
			$this->carga = $cantidad_a_cargar;
			echo "Se ha cargado cantidad: ". $cantidad_a_cargar. "<br />";
		}

		public function verificar_encendido(){
			if($this->encendido == true){
				echo "Camion encendido <br />";
			}
			else{
				echo "Camion apagado <br />";
			}
		}
	}

	class Autobus extends Vehiculo{
		
		private $pasajeros;

		public function subir_pasajeros($cantidad_pasajeros){
			$this->pasajeros = $cantidad_pasajeros;
			echo "Se han subido". $this->pasajeros. "<br />";
		}

		public function verificar_encendido(){
			if($this->encendido == true){
				echo "Autobus encendido <br />";
			}
			else{
				echo "Autobus apagado <br />";
			}
		}
	}

	$Camion = new Camion();
	$Camion->encender();
	$Camion->cargar(10);
	$Camion->verificar_encendido();
	$Camion->matricula = '9627CYV';
	$Camion->apagar();

	$Autobus = new Autobus();
	$Autobus->encender();
	$Autobus->subir_pasajeros(5);
	$Autobus->verificar_encendido();
	$Autobus->matricula = '5623KDF';
	$Autobus->apagar();
?>
</pre>