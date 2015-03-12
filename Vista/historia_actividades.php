<!DOCTYPE html>
<?php 
    include '../Modelo/conexion.php';
    session_start();
    $uActivo = $_SESSION['usuario'];
    
    $conexion=new conexion();

        //Peticion
        $peticionA = $conexion->consulta("SELECT `NOMBRE_UA` FROM `inscripcion` WHERE `NOMBRE_UGE`='$uActivo'");
             while ($correo = mysql_fetch_array($peticionA))
               {        
                      $asesor=$correo["NOMBRE_UA"];
               }

         $peticionGE = $conexion->consulta("SELECT NOMBRE_CORTO_GE FROM grupo_empresa WHERE NOMBRE_U='$uActivo'");
             while ($correo1 = mysql_fetch_array($peticionGE))
               {        
                      $grupoEmpresa=$correo1["NOMBRE_CORTO_GE"];   
               }   
                      
         $peticionNL = $conexion->consulta("SELECT NOMBRE_LARGO_GE FROM grupo_empresa WHERE NOMBRE_U='$uActivo'");
             while ($correo2 = mysql_fetch_array($peticionNL))
               {        
                      $grupoEmpresaNL=$correo2["NOMBRE_LARGO_GE"];
               }                        
                     
?>
   

<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Sistema de Apoyo a la Empresa TIS</title>

    <!-- JQuery -->
    <script type="text/javascript" src="../Librerias/lib/jquery-2.1.0.min.js"></script>
    <!-- icheck -->
    <link href="../Librerias/icheck/skins/square/green.css" rel="stylesheet">
    <script src="../Librerias/lib/icheck.min.js"></script>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="../Librerias/css/bootstrap.min.css" rel="stylesheet">
    <script type="text/javascript" src="../Librerias/lib/bootstrap.js"></script>
    <!-- Docs -->
    <link rel="stylesheet" type="text/css" href="../Librerias/lib/css/docs.css">
    <!-- Font-Awesome -->
    <link rel="stylesheet" type="text/css" href="../Librerias/font-awesome/css/font-awesome.css">
    <!-- Bootstrap-datetimepicker -->
    <link rel="stylesheet" type="text/css" href="../Librerias/lib/css/bootstrap-datetimepicker.css">
    <script type="text/javascript" src="../Librerias/lib/bootstrap-datetimepicker.js"></script>
    <script type="text/javascript" src="../Librerias/lib/bootstrap-datetimepicker.es.js"></script>
    <!-- Bootstrap-multiselect -->
    <link rel="stylesheet" type="text/css" href="../Librerias/lib/css/bootstrap-multiselect.css">
    <script type="text/javascript" src="../Librerias/lib/bootstrap-multiselect.js"></script>
    <!-- Bootstrap-validator -->
    <link rel="stylesheet" type="text/css" href="../Librerias/lib/css/bootstrapValidator.css">
    <script type="text/javascript" src="../Librerias/lib/bootstrapValidator.js"></script>
    <!-- Validators -->
    
    
    <script type="text/javascript" src="../Librerias/lib/validator/diferenteActividadPlanificacion.js"></script>
    <script type="text/javascript" src="../Librerias/lib/validator/diferenteEntregable.js"></script>
    <script type="text/javascript" src="../Librerias/lib/validator/stringLength.js"></script>
    <script type="text/javascript" src="../Librerias/lib/validator/notEmpty.js"></script>
    <script type="text/javascript" src="../Librerias/lib/validator/callback.js"></script>
    <script type="text/javascript" src="../Librerias/lib/validator/date.js"></script>
    <script type="text/javascript" src="../Librerias/lib/validator/numeric.js"></script>
    <script type="text/javascript" src="../Librerias/lib/validator/porcentajeMax.js"></script>
    <script type="text/javascript" src="../Librerias/lib/validator/porcentajeMin.js"></script>
    <!-- JS -->
    <script type="text/javascript" src="../Librerias/lib/funcion.js"></script>
    



    <!-- Page-Level Plugin CSS - Dashboard -->
    <link href="../Librerias/css/plugins/morris/morris-0.4.3.min.css" rel="stylesheet">
    <link href="../Librerias/css/plugins/timeline/timeline.css" rel="stylesheet">
    <!-- SB Admin CSS - Include with every page -->
    <link href="../Librerias/css/sb-admin.css" rel="stylesheet">
    
    
    
    <link href="css/tabla-div1.css" rel="stylesheet" type="text/css" />
    <link href="css/tabla-div.css" rel="stylesheet" type="text/css" />
    <link href="css/style.css" rel="stylesheet" type="text/css" /> 
</head>

<body>

   
<div id="wrapper">
       <nav class="navbar navbar-default navbar-fixed-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                   <a class="navbar-brand" href="inicio_grupo_empresa.php">Inicio </a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">

                <li>
                    <a href="lista-de-noticias-grupo.php"><i class="glyphicon glyphicon-comment"></i> Foro</a>
                </li>

                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <?php echo $uActivo.' '; ?><i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="ModificarGrupoEmpresa.php"><i class="fa fa-user fa-fw"></i> Modificar Datos personales</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="unlog.php"><i class="fa fa-sign-out fa-fw"></i>Salir</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->
            
            <div class="navbar-default navbar-static-side" role="navigation">
                <div class="sidebar-collapse">
                    <ul class="nav" id="side-menu">
                        
                        
                        <li>
                            <a href="#"><i class="fa fa-bar-chart-o fa-files-o "></i> Documentos <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                
                                <li>
                                    <a href="#" >Subir Documentos <span class="fa arrow"></span></a>
                                    <ul class="nav nav-third-level">
                                    <?php
                                    
                                        $docsReq = $conexion->consulta("SELECT NOMBRE_R FROM registro, documento_r, inscripcion, inscripcion_proyecto WHERE inscripcion_proyecto.CODIGO_P = documento_r.CODIGO_P AND documento_r.ID_R = registro.ID_R AND inscripcion_proyecto.NOMBRE_U = '$uActivo' AND inscripcion.NOMBRE_UGE = inscripcion_proyecto.NOMBRE_U");
                                     
                                        while ($rowDocs = mysql_fetch_row($docsReq))
                                        {
                                            
                                            echo '<li>
                                                  <a href="SubirDocumento.php?doc='.$rowDocs[0].'">'.$rowDocs[0].'</a>
                                                   </li>';  
                                            
                                        }
                                        
                                    ?>
                                    </ul>
                                </li>
                                <li>
                                    <a href="publicacion_grupo.php">Recepci&oacute;n Documentos </a>
                                    
                                </li>
                               
                            </ul>
                            
                            <!-- /.nav-second-level -->
                        </li>
                         <li>
                             
                            <a href="#"><i class="fa fa-tasks fa-fw"></i> Tareas<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                 <li>
                                     <a href="AnadirSocio.php">Añadir socios</a>
                                </li>
                                 <li>
                                    <a href="AnadirRL.php">Seleccionar Representante legal</a>
                                </li>
                                <li>
                                    <a href="seleccionar_asesor.php">Seleccionar Asesor</a>
                                </li>
                                
                                 <li>
                                     <a href="InscripcionGEProyecto.php">Inscribirse a proyecto</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        
                        <li>
                            <a href="historia_actividades.php"><i class="glyphicon glyphicon-calendar"></i> Historia de actividades</a>
                        </li>
                        <li>
                            <a id="registrarPlanificacion" href="#">
                                <i class="fa fa-pencil-square-o fa-fw"></i>Registrar Planificaci&oacute;n
                            </a>
                        </li>        
                    </ul>
                    <!-- /#side-menu -->
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            
               
            <!-- /.navbar-static-side -->
        </nav>
     
        <div id="page-wrapper">
        <form id = "ordenc" method = "post" action="" role="form" enctype="multipart/data-form" onsubmit="return validarCampos(ordenc)">
        <div class ="form-horizontal">



        <?php 
  
        
        $peticion6=$conexion->consulta("SELECT * FROM inscripcion WHERE NOMBRE_UGE='$uActivo' and ESTADO_INSCRIPCION='Habilitado'");
        $tamano=mysql_num_rows($peticion6);
        if($tamano>0)
        {
        
            
        
            
        
            $peticion7=$conexion->consulta("SELECT  r.nombre_r, p.fecha_inicio_pl, p.hora_inicio_pl, p.fecha_fin_pl, p.hora_fin_pl FROM plazo p, registro r, tipo t, inscripcion_proyecto i, documento_r d WHERE t.TIPO_T = r.TIPO_T AND p.ID_R = r.ID_R AND r.TIPO_T =  'documento requerido' AND r.NOMBRE_U = '$asesor' AND i.NOMBRE_U='$uActivo' and  d.CODIGO_P=i.CODIGO_P AND r.ID_R=d.ID_R");
            $tamanio=mysql_num_rows($peticion7);
            if($tamanio>0)
            {

                        ?>


                        <div class="historia">

                        <h2><span>ACTIVIDADES EN LINEA</span></h2>
                        </div>
                        <hr>
                        <div class="historia1">
                        <div class="contenedor-fila2">

                        <div class="contenedor-columna">
                        <?php
                        echo "Nombre";
                        ?>
                        </div>  
                        <div class="contenedor-columna">
                        <?php
                        echo "Fecha Inicio";
                        ?>
                        </div>

                        <div class="contenedor-columna">
                        <?php
                        echo "Hora Inicio";
                        ?>
                        </div>
                        <div class="contenedor-columna">
                        <?php
                        echo "Fecha Fin ";
                        ?>
                        </div>
                        <div class="contenedor-columna">
                        <?php
                        echo "Hora Fin";
                        ?>
                        </div>
                        </div>  
                        <?php

                        //Peticion
                        $peticion = $conexion->consulta("SELECT  r.nombre_r, p.fecha_inicio_pl, p.hora_inicio_pl, p.fecha_fin_pl, p.hora_fin_pl FROM plazo p, registro r, tipo t, inscripcion_proyecto i, documento_r d WHERE t.TIPO_T = r.TIPO_T AND p.ID_R = r.ID_R AND r.TIPO_T =  'documento requerido' AND r.NOMBRE_U = '$asesor' AND i.NOMBRE_U='$uActivo' and  d.CODIGO_P=i.CODIGO_P AND r.ID_R=d.ID_R");


                        while($fila = mysql_fetch_array($peticion))
                        {
                        ?>
                        <div class="contenedor-fila">
                        <div class="contenedor-columna">
                        <?php
                        echo $fila['nombre_r'];
                        ?>
                        </div>

                        <div class="contenedor-columna">
                        <?php
                        echo $fila['fecha_inicio_pl'];
                        ?>
                        </div>

                        <div class="contenedor-columna">
                        <?php
                        echo $fila['hora_inicio_pl'];
                        ?>
                        </div>

                        <div class="contenedor-columna">
                        <?php
                        echo $fila['fecha_fin_pl'];
                        ?>
                        </div>

                        <div class="contenedor-columna">
                        <?php
                        echo $fila['hora_fin_pl'];
                        ?>
                        </div>


                        </div>
                        <?php
                        }
            }
            else
            {                     
                $peticion9=$conexion->consulta("SELECT registro.ID_R,registro.NOMBRE_U,registro.NOMBRE_R,registro.FECHA_R,registro.HORA_R  FROM registro, receptor  WHERE  registro.ID_R=receptor.ID_R  and   (RECEPTOR_R='$grupoEmpresaNL' OR RECEPTOR_R='TODOS')");
                $tamanio2=mysql_num_rows($peticion9);
                if($tamanio2<1)
                {  
                        echo '<div class="alert alert-warning">
                              <strong>No existe nunguna actividad registrada</strong>
                              </div>';
                }
            }

        ?>  
                        </div>    
                        <hr>
                        <div class ="form-horizontal">
                        <div class="historia">
        <?php   
        
            $peticion8=$conexion->consulta("SELECT registro.ID_R,registro.NOMBRE_U,registro.NOMBRE_R,registro.FECHA_R,registro.HORA_R  FROM registro, receptor  WHERE  registro.ID_R=receptor.ID_R  and   (RECEPTOR_R='$grupoEmpresaNL' OR RECEPTOR_R='TODOS')");
            $tamanio1=mysql_num_rows($peticion8);
            if($tamanio1>0)
            {
        
                        ?>  
                        <h2><span>ANUNCIOS</span></h2>
                        </div>
                        <hr>
                        <div class="historia1">
                        <div class="contenedor-fila2">

                        <div class="contenedor-columna">
                        <?php
                        echo "ID ";
                        ?>
                        </div>  
                        <div class="contenedor-columna">
                        <?php
                        echo "Asesor";
                        ?>
                        </div>

                        <div class="contenedor-columna">
                        <?php
                        echo "Descripcion";
                        ?>
                        </div>
                        <div class="contenedor-columna">
                        <?php
                        echo "Fecha ";
                        ?>
                        </div>
                        <div class="contenedor-columna">
                        <?php
                        echo "Hora";
                        ?>
                        </div>
                        </div>  
                        <?php

                        $peticion = $conexion->consulta("SELECT registro.ID_R,registro.NOMBRE_U,registro.NOMBRE_R,registro.FECHA_R,registro.HORA_R  FROM registro, receptor  WHERE  registro.ID_R=receptor.ID_R  and   (RECEPTOR_R='$grupoEmpresaNL' OR RECEPTOR_R='TODOS')");


                        while($fila = mysql_fetch_array($peticion))
                        {
                        ?>
                        <div class="contenedor-fila">
                        <div class="contenedor-columna">
                        <?php
                        echo $fila['ID_R'];
                        ?>
                        </div>

                        <div class="contenedor-columna">
                        <?php
                        echo $fila['NOMBRE_U'];
                        ?>
                        </div>

                        <div class="contenedor-columna">
                        <?php
                        echo $fila['NOMBRE_R'];
                        ?>
                        </div>

                        <div class="contenedor-columna">
                        <?php
                        echo $fila['FECHA_R'];
                        ?>
                        </div>

                        <div class="contenedor-columna">
                        <?php
                        echo $fila['HORA_R'];
                        ?>
                        </div>


                        </div>
                        <?php
                        }

            }
            else
            {
                
            }



        ?>  
        </div>    


        </div>

        <hr>

        <?php
        }
        else
        { 
        echo '<div class="alert alert-warning">
        <strong>Su inscripcion no ha sido habilitada</strong>
        </div>';
        }
        ?>             
                 
  </form>
             
    <!--Modal para adjuntar recursos/documentos-->

    </div>       
  
    </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- Core Scripts - Include with every page -->
    
    <!--script src="../Librerias/js/bootstrap.min.js"></script-->
    <script src="../Librerias/js/plugins/metisMenu/jquery.metisMenu.js"></script>

    <!-- SB Admin Scripts - Include with every page -->
    <script src="../Librerias/js/sb-admin.js"></script>

</body>

</html><!DOCTYPE html>