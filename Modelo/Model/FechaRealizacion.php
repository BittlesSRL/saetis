<?php
	require_once '../Modelo/conexion.php';

	class FechaRealizacion {
		var $conexion;
		private $idRegistro;
	    private $fecha;

	    function __construct() {
	        $nargs = func_num_args();
	        $args = func_get_args();
	        $this->conexion = new conexion();
	        if ($nargs == 1) {
                $this->constructor($args[0]);
            } else {
            	$this->idRegistro = $args[0];
            	$this->fecha = $args[1];
            }
	    }

	    function constructor($id) {
	        $this->conexion->conectar();
			$datosFechaRealizacion = $this->conexion->consulta("SELECT ID_R, FECHA_FR FROM fecha_realizacion WHERE ID_R = $id");
			$datosFechaR = mysql_fetch_row($datosFechaRealizacion);
            //$this->idRegistro = $datosFechaRealizacion[0][0];
            $this->idRegistro = $datosFechaR[0];
            //$this->fecha = $datosFechaRealizacion[0][1];
            $this->fecha = $datosFechaR[1];
	        $this->conexion->cerrarConexion();
	    }

	    function insertarBD() {
	        $this->conexion->conectar();
	        $this->conexion->consulta("INSERT INTO fecha_realizacion(id_r, fecha_fr)
	        							VALUES($this->idRegistro, '$this->fecha');");
	        $this->conexion->cerrarConexion();
	    }

	    public function modificarBD() {
	        $this->conexion->conectar();
	        $this->conexion->consulta("UPDATE fecha_realizacion 
										SET fecha_fr = '$this->fecha'
										WHERE id_r = '$this->idRegistro';");
	        $this->conexion->cerrarConexion();
	    }

	    public function getIdRegistro() {
	        return $this->idRegistro;
	    }

	    public function getFecha() {
	        return $this->fecha;
	    }

	    public function setIdRegistro($idRegistro) {
	        $this->idRegistro = $idRegistro;
	    }

	    public function setFecha($fecha) {
	        $this->fecha = $fecha;
	    }
	}
?>
