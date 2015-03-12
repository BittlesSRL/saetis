<?php
  
  include '../Modelo/conexion.php';
  session_start();
  $conexion = new conexion();

  if (isset($_POST['grupoempresa']))
  {
      $nLargoGE = $_REQUEST['grupoempresa'];
      $consulta="SELECT DISTINCT NOMBRE_R FROM `registro` AS r,`receptor` AS w WHERE  r.`ID_R` = w.`ID_R` AND r.`TIPO_T` LIKE 'Contrato' AND w.`RECEPTOR_R` = '$nLargoGE'";
      $contrato= $conexion->consulta($consulta);
      $cantC= mysql_num_rows($contrato);  
      
      if($cantC != 0 )
      {
         echo"<script type=\"text/javascript\">alert('Usted ya emitio un contrato para esta grupo empresa'); window.location='../Vista/contrato.php';</script>";  
      }
      else
      {
         $nombreF= '../Repositorio/asesor/Contrato.tex';
         $existeFile = FALSE;
         if (file_exists($nombreF))
         {
             $existeFile = TRUE;
         }
         if($existeFile)
         {
            if(strnatcasecmp($nLargoGE, "Seleccione una grupo empresa") != 0)
            {
                $seleccion="SELECT `NOMBRE_CORTO_GE` FROM `grupo_empresa` WHERE `NOMBRE_LARGO_GE` = '$nLargoGE'";            
                $consulta = $conexion->consulta($seleccion);
                $nCortoGE =  mysql_fetch_array($consulta);
                
                $nombreUA = $_SESSION['usuario'] ;
                $nomAp = $conexion->consulta("SELECT NOMBRES_A, APELLIDOS_A FROM asesor WHERE NOMBRE_U =  '$nombreUA' ");
                $nombreAp = mysql_fetch_row($nomAp);
                $asesor = $nombreAp[0]." ".$nombreAp[1] ;
    
                $seleccion = "SELECT `REPRESENTANTE_LEGAL_GE` FROM `grupo_empresa` WHERE `NOMBRE_LARGO_GE` = '$nLargoGE'";            
                $consulta = $conexion->consulta($seleccion);
                $represen = mysql_fetch_array($consulta);
                
                $seleccion = "SELECT `NOMBRE_U` FROM `grupo_empresa` WHERE `NOMBRE_LARGO_GE` = '$nLargoGE'";            
                $consulta = $conexion->consulta($seleccion);
                $nombreUGE = mysql_fetch_array($consulta);
                
                $seleccion = "SELECT p.`NOMBRE_P` FROM `proyecto` AS p, `inscripcion_proyecto` AS ip WHERE ip.`NOMBRE_U` = '$nombreUGE[0]' AND ip.`CODIGO_P` = p.`CODIGO_P`";
                $consulta = $conexion->consulta($seleccion);
                $sistema = mysql_fetch_array($consulta);
                
                $seleccion = "SELECT p.`CONVOCATORIA` FROM `proyecto` AS p, `inscripcion_proyecto` AS ip WHERE ip.`NOMBRE_U` = '$nombreUGE[0]' AND ip.`CODIGO_P` = p.`CODIGO_P`";
                $consulta = $conexion->consulta($seleccion);
                $convo = mysql_fetch_array($consulta);

                $consulta = $conexion->consulta("SELECT * FROM planificacion WHERE NOMBRE_U='$nombreUGE[0]' AND ESTADO_E='planificacion registrada'");
                $planifi = mysql_fetch_row($consulta);

                if (is_array($planifi))
                {       
                    $buscar    = array(
                        'empresa_nombre_largo' => '[[empresa-nombre-largo]]',
                        'empresa_nombre_corto' => '[[empresa-nombre-corto]]',
                        'rep_legal'            => '[[rep-legal]]',
                        'asesor'               => '[[asesor]]',
                        'fecha_actual'         => '[[fecha-actual]]',
                        'hora_actual'          => '[[hora-actual]]',
                        'sistema'              => '[[sistema]]',
                        'convocatoria'         => '[[convocatoria]]',   
                    );
                    
                    $remplazo['empresa_nombre_largo'] = $nLargoGE;
                    $remplazo['empresa_nombre_corto'] = $nCortoGE[0];
                    $remplazo['rep_legal']            = $represen[0];
                    $remplazo['asesor']               = $asesor;
                    $remplazo['fecha_actual']         = date('Y/m/d');
                    $remplazo['sistema']              = $sistema[0];
                    $remplazo['convocatoria']         = $convo[0];
                        
                    $ruta = "../Repositorio/asesor";
                    
                    chdir($ruta);
                        
                    $id = "Contrato";
                    $tex = $id.".tex"; 
                    $log = $id.".log"; 
                    $aux = $id.".aux";
                    $nombCorto = str_replace(' ', '', $nCortoGE[0]);
                    $pdf = $id.$nombCorto.".pdf"; 
                    
                    $plantilla = "Contrato.tex";
                    $texto = file_get_contents($plantilla);
                    $textoAux = file_get_contents($plantilla);
                    $texto = str_replace($buscar['empresa_nombre_largo'], $remplazo['empresa_nombre_largo'], $texto);
                    $texto = str_replace($buscar['empresa_nombre_corto'], $remplazo['empresa_nombre_corto'], $texto);
                    $texto = str_replace($buscar['rep_legal'], $remplazo['rep_legal'], $texto);
                    $texto = str_replace($buscar['asesor'], $remplazo['asesor'], $texto);
                    $texto = str_replace($buscar['fecha_actual'], $remplazo['fecha_actual'], $texto);
                    $texto = str_replace($buscar['sistema'], $remplazo['sistema'], $texto);
                    $texto = str_replace($buscar['convocatoria'], $remplazo['convocatoria'], $texto);
                        
                    file_put_contents($tex,$texto);
                    exec("pdflatex -interaction=nonstopmode $tex",$final);
                    file_put_contents($tex, $textoAux);
                    unlink($log);
                    unlink($aux);
                    
                    $rutaDir="../".$nombreUA."/Contratos/";
                    $file = "Contrato".'_'.$nombreUA.'.pdf';
                    
                    if (!file_exists($rutaDir)) 
                    {
                        $oldmask = umask(0); 
                        mkdir($rutaDir, 0777,TRUE);
                        umask($oldmask);
                        
                        if(!file_exists("../".$nombreUA."/index.html"))
                        {
                                fopen("../".$nombreUA."/index.html", "x");
                        }
                    }
                                                   
                    rename("Contrato.pdf", $file);
                    rename($file, $rutaDir.$pdf );
                    
                    $descrip = "../Repositorio/".$nombreUA."/Contratos/".$pdf;
                    $fecha = date('Y-m-d');
                    $hora = date("G:H:i");
                    $visible = "TRUE";
                    $descargar = "TRUE";
                    $comentar = $conexion->consulta("INSERT INTO registro (NOMBRE_U,TIPO_T,ESTADO_E,NOMBRE_R,FECHA_R,HORA_R) VALUES ('$nombreUA','Contrato','Habilitado','$pdf','$fecha','$hora')")or
                    die("Error");
                                                   
                    $consultar= $conexion->consulta("SELECT MAX(ID_R) AS 'ID_R' FROM registro");
                    
                    if ($regis = mysql_fetch_row($consultar)) 
                    {
                        $idRegis = trim($regis[0]);
                    }
                                                   
                    $guardar = $conexion->consulta("INSERT INTO documento (ID_R,TAMANIO_D,RUTA_D,VISUALIZABLE_D,DESCARGABLE_D) VALUES('$idRegis','1024','$descrip','$visible','$descargar')");
                    $desD = $conexion->consulta("INSERT INTO descripcion (ID_R,DESCRIPCION_D) VALUES('$idRegis','Contrato')");
                    $destinat = $conexion->consulta("INSERT INTO receptor (ID_R,RECEPTOR_R) VALUES('$idRegis','$nLargoGE')");
                     
                     $selGE=$conexion->consulta("SELECT `NOMBRE_U` FROM `grupo_empresa` WHERE `NOMBRE_LARGO_GE` = '$nLargoGE'");
                     $nomGE=mysql_fetch_array($selGE);

                     $estaFir=  $conexion->consulta("UPDATE `inscripcion_proyecto`
                     SET `ESTADO_CONTRATO`= 'Firmado'                   
                    WHERE `NOMBRE_U` = '$nomGE[0]'");  
                    //rename("Contrato.pdf", $pdf);

                   /* if(!file_exists("../".$nombreUA."/Contratos/index.html"))
                    {
                        $directorioIndex = "../".$nombreUA."/Contratos/index.html";
                        fopen($directorioIndex, "x");
                    }*/
                    
                    echo"<script type=\"text/javascript\">alert('Se genero el contrato correctamente'); window.location='../Vista/contrato.php';</script>";                    
                }
                else
                {
                    echo"<script type=\"text/javascript\">alert('La grupo empresa seleccionada no ha registrado aun su planificacion'); window.location='../Vista/contrato.php';</script>";  

                }
                
            }
            else{        
            
               echo"<script type=\"text/javascript\">alert('Por favor, seleccione una grupo empresa'); window.location='../Vista/contrato.php';</script>";  
            }
        }
        else
        {
             echo"<script type=\"text/javascript\">alert('Por favor, suba la plantilla del Contrato a su repositorio); window.location='../Vista/contrato.php';</script>";
                                
        }
        
      }
  }
?>