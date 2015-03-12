<?php
    require_once '../Modelo/Model/Planificacion.php';
    require_once '../Modelo/Model/Entregable.php';
    require_once '../Modelo/Model/Registro.php';
    require_once '../Modelo/Model/Precio.php';
    require_once '../Modelo/Model/FechaRealizacion.php';
    require_once '../Modelo/Model/Reporte.php';

    $funcion = $_POST['funcion'];
    $u = $_POST['usuario'];

    switch ($funcion) {
        case 'registrar asistencia':
          $conexion = new Conexion();
      $conexion->conectar();

      $s = $conexion->consultarTabla("SELECT codigo_s, nombres_s, apellidos_s
                          FROM socio
                          WHERE nombre_u = '$u';");
      $conexion->cerrarConexion();
      $filas = '';
      $scripts = '';
      for ($i = 0; $i < count($s); $i++) {
            $filas .= '<tr data-codigo="'.$s[$i][0].'" data-nombre="'.$s[$i][1].' '.$s[$i][2].'">
                   <td class="col-md-4">'.$s[$i][0].'</td>
                 <td class="col-md-4">'.$s[$i][1].' </br>'.$s[$i][2].'</td>
                     <td class="col-md-4">
                             <div class="form-group">
                                 <div class="radio">
                                     <label><input type="radio" name="Asistencia'.$s[$i][0].'" value="presente" checked/> presente</label>
                                 </div>
                                 <div class="radio">
                                      <label><input type="radio" name="Asistencia'.$s[$i][0].'" value="ausente" /> ausente</label>
                                 </div>
                                 <div class="radio">
                                      <label><input type="radio" name="Asistencia'.$s[$i][0].'" value="licencia" /> licencia</label>
                                 </div>
                             </div>
                         </td>
               </tr>';

        $scripts .= '<script>
                   $("#registroAsistencia").find("form")
                        .bootstrapValidator("addField", "Asistencia'.$s[$i][0].'", {
                            validators: {
                                notEmpty: {
                                    message: "Seleccione una opcion"
                                } 
                            }
                        });
                  $("#registroAsistencia").find("form")
                        .find("[name='."'".'Asistencia'.$s[$i][0]."'".']")
                            .iCheck({
                                checkboxClass: "icheckbox_square-green",
                                radioClass: "iradio_square-green"
                            })
                            .on("ifChanged", function(e) {
                                var field = $(this).attr("name");
                                $("#registroAsistencia").find("form")
                                    .bootstrapValidator("updateStatus", field, "NOT_VALIDATED")
                                      .bootstrapValidator("validateField", field);
                            });
                  </script>';
        }
        echo '<div class="container-fluid">
            <div id="registroAsistencia" data-grupoe="'.$u.'">
                  <form class="form-horizontal"> 
                            <legend>Registro de asistencia</legend>
                            <table class="table table-bordered table-responsive table-highlight">
                              <thead>
                                    <tr>
                                        <th>Codigo</th>
                                        <th>Socio</th>
                                        <th>Asistencia</th>
                                    </tr>
                                </thead>
                                <tbody>'
                                    .$filas.
                               '</tbody>
                        </table> 
                  <div class="form-group">
                                  <div class="col-md-12">
                                    <div class="col-md-4 pull-right">
                                      <button type="submit" class="btn btn-primary btn-block pull-right">Registrar reportes</button>
                                    </div>
                                  </div>
                                </div>
                    </form>
                </div>
            </div>
                <script>registrarAsistenciaSemanal()</script>                        
            '.$scripts;
      break;


      case 'registrar seguimiento':
      $conexion = new Conexion();
      $conexion->conectar();
      $fechas=$conexion->consulta("SELECT DISTINCT `FECHA_S` FROM seguimiento WHERE seguimiento.GRUPO_S='$u' ORDER BY FECHA_S DESC ");
      
      
      ?>
      
 

      <?php


      while ($fechasSegui = mysql_fetch_array($fechas))
     { 
         $fechaArr=$fechasSegui[0];

         echo "<div class='bs-callout bs-callout-info'>
              <h4>".$fechaArr."</h4>
          </div>";
          $peticionGE = $conexion->consulta("SELECT `ROL_S`,`ACTIVIDAD_S`,`HECHO_S`,`RESULTADO_S`,`CONCLUSION_S`,`OBSERVACION_S`  FROM seguimiento WHERE seguimiento.GRUPO_S='$u' AND FECHA_S ='$fechaArr'");
        
             while ($seguimiento = mysql_fetch_array($peticionGE))
            { 


                $rolGE=$seguimiento[0];
                $actividad=$seguimiento[1];
                $hechoGE=$seguimiento[2];
                $resultado=$seguimiento[3];
                $conclusion=$seguimiento[4];
                $obserGE=$seguimiento[5];
               

              
                if($hechoGE=="1")
                {
                  $hechoGE1="si";
                }
                else
                {
                  $hechoGE1="no";
                }
               
                $tabla="<b>Rol:</b> ".$rolGE."</br>
                <b>Hecho:</b> ".$hechoGE1."</br>";

                $tabla.=" <form class='form-horizontal'> <fieldset class='campos-border'> <table class='table table-bordered table-responsive table-highlight'>
                 <thead>
                   <tr>
                      
                      <th>Actividad</th>
                      <th>Resultado</th>
                      <th>Conclusion</th>
                      <th>Observacion</th>
                   </tr>";
             
                $tabla.="<tr>
                                
                                       <td class='col-md-2'>
                                           <div class='form-group'>
                                               <div class='col-md-12'>
                                                   ".$actividad."
                                               </div>
                                           </div>
                                       </td>";
                                    


                    
                                                   
                            $tabla.= "
                                       <td class='col-md-2'>
                                           <div class='form-group'>
                                               <div class='col-md-12'>
                                                   ".$resultado."
                                               </div>
                                           </div>
                                       </td>
                                       <td class='col-md-2'>
                                           <div class='form-group'>
                                               <div class='col-md-12'>
                                                   ".$conclusion."
                                               </div>
                                           </div>
                                       </td>
                                       <td class='col-md-2'>
                                           <div class='form-group'>
                                               <div class='col-md-12'>
                                                   ".$obserGE."
                                               </div>
                                           </div>
                                       </td>
                                       
                                   </tr>";
                
                 
               
                $tabla.=" </thead> 
                </table> </fieldset></form></div>";
                echo $tabla;

               
                         
         }

        

    } 
      

      break;

    case 'registrar reportes':

      $rr = Reporte::listaRolesReporte();

            $rolesReporte = '<select class="btn-primary" name="roles" multiple="multiple">';
            for ($i = 0; $i < count($rr); $i++) { 
                $rolesReporte .= '<option value="'.$rr[$i].'">'.$rr[$i].'</option>';
            }
            $rolesReporte .= '</select>';

      echo '<div class="container-fluid">
            <div id="registroRol">
                          <legend>Registro del rol y las actividades</legend>
                          <div class="bs-callout bs-callout-info">
                              <h4>Nota</h4>
                              <p>
                                  Elija un rol y escriba las actividades a realizarse...
                              </p>
                          </div>
                          <form class="form-horizontal"> 
                              <div class="form-group">
                                  <label class="col-md-1 control-label">Rol</label>
                                  <div class="col-md-3">
                                      '.$rolesReporte.'                                     
                                  </div>
                              </div>
                              <div class="form-group">
                                  <div class="col-md-offset-1 col-md-3 ">
                                    <div class="col-md-6">
                                        <button id="btnCancelarRol" class="btn btn-primary btn-block" style="display: none;">Cancelar</button>
                                    </div>
                                    <div class="col-md-6">
                                      <button type="submit" class="btn btn-primary btn-block">Agregar</button>
                                    </div>
                                  </div>            
                              </div>
                          </form>
            </div>
            <div id="registroReportes" style="display: none;" data-grupoe="'.$u.'">
                          <form class="form-horizontal"> 
                            <legend>Registro de reportes</legend>
                            <div class="bs-callout bs-callout-warning">
                                <h4>Nota</h4>
                                <p>
                                    Revise los reportes agregados antes de registrarlos...
                                </p>
                            </div>
                            <table class="table table-bordered table-responsive table-highlight">
                              <thead>
                                    <tr>
                                        <th>Rol</th>
                                        <th>Actividades</th>
                                        <th>Hecho</th>
                                        <th>Resultados</th>
                                        <th>Conclusiones</th>
                                        <th>Observaciones</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody> 
                                </tbody>
                            </table> 
                            <div class="form-group">
                                <div class="col-md-12">
                                  <div class="col-md-2 pull-left">
                                    <button type="button" id="btnAgregarRol" class="btn btn-primary btn-block">Agregar rol</button>
                                  </div>
                                  <div class="col-md-2 pull-right">
                                    <button type="submit" class="btn btn-primary btn-block">Registrar reportes</button>
                                  </div>
                                </div>
                              </div>
                        </form>                        
                      </div>
                  </div>
                  <script>registrarReportesSemanal()</script>';
      break;
    }
    
?>