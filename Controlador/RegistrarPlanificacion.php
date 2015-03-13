<?php
	date_default_timezone_set("America/La_Paz");
	require_once '../Modelo/Model/Planificacion.php';
	require_once '../Modelo/Model/Registro.php';
	require_once '../Modelo/Model/FechaRealizacion.php';
	require_once '../Modelo/Model/Entregable.php';
	require_once '../Modelo/Model/Precio.php';
	require_once '../Modelo/Model/Entrega.php';
	require_once '../Modelo/Model/Pago.php';

	
        session_start();
        $usuario=$_SESSION['usuario'];
        
        /*$usuario = 'Bittle';*/
        $planificacion = new Planificacion($usuario);
        $estado = $planificacion->getEstado();

	switch ($estado) {
        case 'registrar planificacion':
            $actividades = explode(',', $_POST['actividades']);
			$fechas = explode(',', $_POST['fechas']);
			for ($i = 0; $i < count($actividades); $i++) { 
				$fechaActual = date("Y")."-".date("m")."-".date("d");
				$horaActual = date("H").":".date("i").":".date("s");
				$actividad = $actividades[$i];
				$fecha = $fechas[$i];
				$registro = new Registro($usuario, 'actividad planificacion', 'en proceso', $actividad, $fechaActual, $horaActual);
				$registro->insertarBD();
				$fechaRealizacion = new FechaRealizacion($registro->getId(), $fecha);
				$fechaRealizacion->insertarBD();
			}
			$planificacion->setEstado('registrar entregables');
			$planificacion->modificarBD();
			echo ('<div class="alert alert-success">
					   <strong>Planificacion registrada...</strong>
				   </div>
				   <script>$("#page-wrapper").load("vistaRegistrarPlanificacion.php");</script>');
            break;
        case 'registrar entregables':
			$entregables = explode(',', $_POST['entregables']);
			$descripciones = explode(',', $_POST['descripciones']);
			for ($i = 0; $i < count($entregables); $i++) { 
				$entregable = new Entregable($usuario, $entregables[$i], $descripciones[$i]);
				$entregable->insertarBD();
			}
			$planificacion->setEstado('registrar costo total proyecto');
			$planificacion->modificarBD();
			echo ('<div class="alert alert-success">
				       <strong>Entregables registrados...</strong>
				   </div>
				   <script>$("#page-wrapper").load("vistaRegistrarPlanificacion.php");</script>');
            break;
        case 'registrar costo total proyecto':
        	$costo = $_POST['costo'];
                $porcentajeA = $_POST['porcentajeA'];
                //$porcentajeA = 70;
        	$precio = new Precio($usuario, $costo);
                $precio->setPorcentajeA($porcentajeA);
        	$precio->insertarBD();
        	$planificacion->setEstado('registrar plan pagos');
                
                $planificacion->modificarBD();
           echo ('<div class="alert alert-success">
				       <strong>Costo total proyecto registrado...</strong>
				   </div>
				   <script>$("#page-wrapper").load("vistaRegistrarPlanificacion.php");</script>');
            break;

        case 'registrar plan pagos':
			$actividades = explode(',', $_POST['actividades']);
			$fechas = explode(',', $_POST['fechas']);
			$porcentajes = explode(',', $_POST['porcentajes']);
			$montos = explode(',', $_POST['montos']);
			$entregables = explode('|', $_POST['entregables']);
			for ($i = 0; $i < count($actividades); $i++) { 
				$fechaActual = date("Y")."-".date("m")."-".date("d");
				$horaActual = date("H").":".date("i").":".date("s");
				$actividad = $actividades[$i];
				$fecha = $fechas[$i];
				$porcentaje = $porcentajes[$i];
				$monto = $montos[$i];
				$entregable = explode(',', $entregables[$i]);

				$registro = new Registro($usuario, 'pago planificacion', 'en proceso', $actividad, $fechaActual, $horaActual);
				$registro->insertarBD();

				$fechaRealizacion = new FechaRealizacion($registro->getId(), $fecha);
				$fechaRealizacion->insertarBD();

				$pago = new Pago($registro->getId(), $monto, $porcentaje);
				$pago->insertarBD();

				for ($j = 0; $j < count($entregable); $j++) { 
					//$e = $entregable[$j];
					$entrega = new Entrega($registro->getId(), $entregable[$j], 0);
					$entrega->insertarBD();
				}
			}
			$planificacion->setEstado('planificacion registrada');
			$planificacion->modificarBD();
			
			echo ('<div class="alert alert-success">
				       <strong>Planificacion registrada...</strong>
				   </div>');
            break;
    }
?>