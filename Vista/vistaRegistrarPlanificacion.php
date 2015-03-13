<?php
  	require_once '../Modelo/Model/Planificacion.php';
  	require_once '../Modelo/Model/Entregable.php';
    require_once '../Modelo/Model/Registro.php';
    require_once '../Modelo/Model/Precio.php';
    require_once '../Modelo/Model/FechaRealizacion.php';
    require_once '../Modelo/conexion.php';
    session_start();
        
    $uActivo = $_SESSION['usuario'];
    $con = new conexion();
    $Ver_Usr = $con->consulta("SELECT NOMBRE_U FROM usuario WHERE NOMBRE_U = '$uActivo' ");
    $Ver_Usr2 = mysql_fetch_row($Ver_Usr);
        
    $usuario = $uActivo;
    
    if (!is_array($Ver_Usr2)) {   
        $Cons_GE = "SELECT `NOMBRE_U` FROM socio WHERE `NOMBRES_S` = '$uActivo'";
        $Cons_GE2 = $con->consulta($Cons_GE);
        $Nom_User = mysql_fetch_row($Cons_GE2);
        $usuario=$Nom_User[0];
    }
    
    $Verif_In = $con->consulta("SELECT NOMBRE_UA FROM inscripcion, inscripcion_proyecto WHERE NOMBRE_UGE = '$uActivo' and NOMBRE_U = '$uActivo'");
    $Inscrip = mysql_fetch_row($Verif_In);
    $Sel_NL = $con->consulta("SELECT NOMBRE_LARGO_GE FROM grupo_empresa WHERE NOMBRE_U='$uActivo'");
    $NombreL = mysql_fetch_row($Sel_NL);
    $Sel_NC = $con->consulta("SELECT NOMBRE_CORTO_GE FROM grupo_empresa WHERE NOMBRE_U='$uActivo'");
    $NombreC = mysql_fetch_row($Sel_NC);
    $Grupo_NC = 'Notificacion de Conformidad de '.$NombreC[0].'';
    $Sel_NC = $con->consulta("SELECT * FROM registro,receptor WHERE NOMBRE_U='$Inscrip[0]' AND NOMBRE_R='$Grupo_NC' AND registro.ID_R = receptor.ID_R");
    $NC = mysql_num_rows($Sel_NC);
    $Grupo_OC = 'Orden de Cambio de '.$NombreC[0].'';
    $Sel_OC = $con->consulta("SELECT * FROM registro,receptor WHERE NOMBRE_U='$Inscrip[0]' AND NOMBRE_R='$Grupo_OC' AND registro.ID_R = receptor.ID_R");
    $OC = mysql_num_rows($Sel_OC);
    if(is_array($Inscrip))
    {
      if($NC >= 1 or $OC>=1)
      {
        $Planif = new Planificacion($usuario);
        $estado = $Planif->getEstado();
    
            switch ($estado) {
            case 'registrar planificacion':
                echo '<div id="registroActividadPlanificacion">
                          <legend>Registro de actividad para la planificacion</legend>
                          <div class="bs-callout bs-callout-info">
                              <h4>Nota</h4>
                              <p>
                                  Registre una actividad de su planificacion... 
                              </p>
                          </div>
                          <form class="form-horizontal"> 
                              <div class="form-group">
                                  <label class="col-md-2 control-label">Actividad</label>        
                                  <div class="col-md-3">
                                      <input type="text" class="form-control" name="actividad"> 
                                  </div>
                              </div>                              
                              <div class="form-group">
                                  <label class="col-md-2 control-label">Fecha</label>
                                  <div class="col-md-3">
                                      <input type="date" class="form-control" name="fecha">
                                  </div>
                              </div>
                              <div class="form-group">
                                  <div class="col-md-offset-2 col-md-3">
                                      <div class="col-md-6">
                                          <button id="btnCancelarActividadPlanificacion" class="btn btn-primary btn-block" style="display: none;">Cancelar</button>
                                      </div>
                                      <div class="col-md-6">
                                          <button type="submit" class="btn btn-primary btn-block">Agregar</button>
                                      </div>
                                  </div>
                              </div>
                          </form>
                      </div>
                      <div id="registroPlanificacion" style="display: none;" data-actividades="">
                          <legend>Registro de planificacion</legend>
                          <div class="bs-callout bs-callout-warning">
                              <h4>Nota</h4>
                              <p>
                                  Revise las actividades agregadas antes de registrar su planificacion. El registro de las actividades de su planificacion solo se realiza una vez.
                              </p>
                          </div>
                          <table class="table table-bordered table-responsive table-highlight">
                              <thead>
                                  <tr>
                                      <th>Actividad</th>
                                      <th>Fecha</th>
                                      <th>Accion</th>
                                  </tr>
                              </thead>
                              <tbody></tbody>
                          </table>
                          <div class="col-md-12">
                              <div class="col-md-3 pull-left">
                                  <button id="btnAgregarActividadPlanificacion" class="btn btn-primary btn-block">Agregar actividad</button>
                              </div>
                              <div class="col-md-3 pull-right">
                                  <button id="btnRegistrarPlanificacion" class="btn btn-primary btn-block">Registrar actividades</button>
                              </div>
                          </div>
                      </div>
                      <script>registrarPlanificacion()</script>';
                break;
            case 'registrar entregables':
                echo '<div id="registroEntregable">
                          <legend>Registro de entregable para el plan de pagos</legend>
                          <div class="bs-callout bs-callout-info">
                              <h4>Nota</h4>
                              <p>
                                  Registre un entregable de su plan de pagos...
                              </p>
                          </div>
                          <form class="form-horizontal"> 
                              <div class="form-group">
                                  <label class="col-md-2 control-label">Entregable</label>        
                                  <div class="col-md-3">
                                      <input type="text" class="form-control" name="entregable"> 
                                  </div>
                              </div>            
                              <div class="form-group">
                                  <label class="col-md-2 control-label">Descripcion</label>
                                  <div class="col-md-3">
                                      <textarea class="form-control" rows="3" name="descripcion"></textarea>
                                  </div>
                              </div>                    
                              <div class="form-group">
                                  <div class="col-md-offset-2 col-md-3">
                                      <div class="col-md-6">
                                          <button id="btnCancelarEntregable" class="btn btn-primary btn-block" style="display: none;">Cancelar</button>
                                      </div>
                                      <div class="col-md-6">
                                          <button type="submit" class="btn btn-primary btn-block">Agregar</button>
                                      </div>
                                  </div>            
                              </div>
                          </form>
                      </div>
                      <div id="registroEntregables" style="display: none;" data-entregables="">
                          <legend>Registro de entregables</legend>
                          <div class="bs-callout bs-callout-warning">
                              <h4>Nota</h4>
                              <p>
                                  Revise los entregables agregados antes de registrarlos. El registro de los entregables para el plan de pagos solo se realiza una vez...
                              </p>
                          </div>
                          <table class="table table-bordered table-responsive table-highlight">
                              <thead>
                                  <tr>
                                      <th>Entregable</th>
                                      <th>Descripcion</th>
                                      <th>Accion</th>
                                  </tr>
                              </thead>
                              <tbody>
                              </tbody>
                          </table>
                          <div class="col-md-12">
                              <div class="col-md-3 pull-left">
                                  <button id="btnAgregarEntregable" class="btn btn-primary btn-block">Agregar entregable</button>
                              </div>
                              <div class="col-md-3 pull-right">
                                  <button id="btnRegistrarEntregables" type="button" class="btn btn-primary btn-block">Registrar entregables</button>
                              </div>
                          </div>
                      </div>
                      <script>registrarEntregables()</script>';
                break;
            case 'registrar costo total proyecto':
                echo '<div id="registroCostoProyecto">
                          <legend>Registro del costo total del proyecto</legend>
                          <div class="bs-callout bs-callout-warning">
                              <h4>Nota</h4>
                              <p>
                                  Revise el costo ingresado y el porcentaje de aceptacion antes de registrarlo. El registro del costo total del proyecto solo se realiza una vez.
                              </p>
                          </div>
                          <form class="form-horizontal"> 
                              <div class="form-group">
                                  <label class="col-md-2 control-label">Costo total proyecto</label>        
                                  <div class="col-md-3">
                                      <input type="text" class="form-control" name="costo"> 
                                  </div>
                              </div>    
                              <div class="form-group">
                                  <label class="col-md-2 control-label">Porcentaje de aceptacion del proyecto</label>        
                                  <div class="col-md-3">
                                      <input type="text" class="form-control" name="porcentajeA"> 
                                  </div>
                              </div> 
                              <div class="form-group">
                                  <div class="col-md-offset-2 col-md-3">
                                      <button type="submit" class="btn btn-primary btn-block">Registrar</button>
                                  </div>
                              </div>
                          </form>
                      </div>
                      <script>registrarCostoProyecto()</script>';
                break;
            case 'registrar plan pagos':
                $ap = Registro::listaActividadesPlanificacion($usuario);
                $actividadesPlanificacion = '<select class="btn-primary" name="actividades" multiple="multiple">';
                for ($i = 0; $i < count($ap); $i++) { 
                    $f = new FechaRealizacion($ap[$i][0]);

                    $actividadesPlanificacion .= '<option data-fecha="'.$f->getFecha().'" value="'.$ap[$i][1].'">'.$ap[$i][1].'</option>';
                }
                $actividadesPlanificacion .= '</select>';
                $e = Entregable::listaEntregables($usuario);
                $entregables = '<select class="btn-primary" name="entregables" multiple="multiple">';
                for ($i = 0; $i < count($e); $i++) { 
                    $entregables .= '<option value="'.$e[$i].'">'.$e[$i].'</option>';
                }
                $entregables .= '</select>';
                $p = new Precio($usuario);
                $costo = $p->getPrecio();
                echo '<div id="registroPago">
                          <legend>Registro de pago para el plan de pagos</legend>
                          <div class="bs-callout bs-callout-info">
                              <h4>Nota</h4>
                              <p>
                                Registre un pago para su plan de pagos...
                              </p>
                          </div>
                          <form class="form-horizontal"> 
                              <div class="form-group">
                                  <label class="col-md-3 control-label">Actividad</label>
                                  <div class="col-md-6">
                                      '.$actividadesPlanificacion.'                                       
                                  </div>
                              </div>            
                              <div class="form-group">
                                  <label class="col-md-3 control-label">Entregables</label>
                                  <div class="col-md-6">
                                      '.$entregables.'                                      
                                  </div>
                              </div>
                              <div class="form-group">
                                  <label class="col-md-3 control-label">Porcentaje del costo total</label>        
                                  <div class="col-md-2">
                                      <input type="text" class="form-control" name="porcentaje">
                                  </div>
                              </div> 
                              <div class="form-group">
                                  <div class="col-md-offset-6 col-md-3 ">
                                    <div class="col-md-6">
                                        <button id="btnCancelarPago" class="btn btn-primary btn-block" style="display: none;">Cancelar</button>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-primary btn-block">Agregar</button>
                                    </div>
                                  </div>            
                              </div>
                          </form>
                      </div>
                      <div id="registroPlanPagos" style="display: none;" data-costo="'.$costo.'" data-max="100" data-min="0">
                          <legend>Registro de plan de pagos</legend>
                          <div class="bs-callout bs-callout-warning">
                              <h4>Nota</h4>
                              <p>
                                  Para registrar el plan de pagos debe registrar pagos cuyos porcentajes del total sumen 100%...
                              </p>
                          </div>
                          <table class="table table-bordered table-responsive table-highlight">
                              <thead>
                                  <tr>
                                      <th>Actividad</th>
                                      <th>Fecha</th>
                                      <th>Porcentaje del total</th>
                                      <th>Monto</th>
                                      <th>Entregables</th>
                                      <th>Accion</th>
                                  </tr>
                              </thead>
                              <tbody>
                              </tbody>
                          </table>
                          <div class="col-md-12">
                              <div class="col-md-3 pull-left">
                                  <button id="btnAgregarPago" class="btn btn-primary btn-block">Agregar pago</button>
                              </div>
                              <div class="col-md-3 pull-right">
                                  <button id="btnRegistrarPlanPagos" type="button" class="btn btn-primary btn-block" style="display: none;">Registrar plan de pagos</button>
                              </div>
                          </div>  
                      </div>
                      <script>registrarPlanPagos()</script>';
                break;
            case 'planificacion registrada':
                echo ('<div class="alert alert-success">
                           <strong>Su planificacion ya se encuentra registrada...</strong>
                       </div>');
                break;
        }
      }
      else
      {
        echo '<div class="alert alert-warning">
                <strong>Podra registrar su planificacion una vez se haya emitido una orden de cambio o notificacion de conformidad para su grupo empresa</strong>
              </div>';
      }
    }
    else
    {
        echo '<div class="alert alert-warning">
                <strong>Primero debe inscribirse a un proyecto en la opcion "Inscribirse a proyecto"</strong>
              </div>';
    }	
    
?>