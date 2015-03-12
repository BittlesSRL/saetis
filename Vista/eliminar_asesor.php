<?php
session_start();
include '../Modelo/conexion.php';
$conect = new conexion();
//Crear variables--------------------------
$usuario = $_SESSION['usuario'];
$contrasena = $_SESSION['contrasena'];
$idAsesor = $_GET['id_us'];
//conexion-------------
    
    //Verificar registros
    $selAsesor = $conect->consulta("SELECT ID_R FROM registro WHERE NOMBRE_U='$idAsesor'");
    $regisAse = mysql_fetch_row($selAsesor);
    
 
    if(isset($_GET['op']))
    {
        $op = $_GET['op'];
       
        if($op == 'si')
        {
           
            $peticion =mysql_num_rows( $conect->consulta(" SELECT * FROM `comentarios` WHERE NOMBRE_U ='$idAsesor'"));
            if($peticion>0){
                 $delComen = $conect->consulta(" DELETE FROM `comentarios` WHERE NOMBRE_U='$idAsesor'");
            }
            $tamNoti =mysql_num_rows( $conect->consulta(" SELECT * FROM `noticias` WHERE NOMBRE_U ='$idAsesor'"));
            if($tamNoti>0){
                 $delNoti = $conect->consulta(" DELETE FROM `noticias` WHERE NOMBRE_U='$idAsesor'");
            }
            
            $selRegis =$conect->consulta(" SELECT ID_R FROM `registro` WHERE NOMBRE_U ='$idAsesor'");
            $tamRegis=mysql_num_rows($selRegis);
            
           
            if($tamRegis>0){
                while($filaR = mysql_fetch_array($selRegis))
                {
                    $idRegis=$filaR[0];
                    $delDesc=$conect->consulta(" DELETE FROM `descripcion` WHERE ID_R='$idRegis'");
                    $delSeguimi = $conect->consulta("DELETE FROM seguimiento WHERE ID_R = '$idRegis' ");
                    $delAsistencia = $conect->consulta("DELETE FROM asistencia_semanal WHERE ID_R = '$idRegis' ");
                    $delDoc=$conect->consulta(" DELETE FROM `documento` WHERE ID_R='$idRegis'");
                    $delPer = $conect->consulta("DELETE FROM periodo WHERE ID_R = '$idRegis' ");
                    $delPlazo = $conect->consulta("DELETE FROM plazo WHERE ID_R = '$idRegis' ");
                    $delRecp = $conect->consulta("DELETE FROM receptor WHERE ID_R = '$idRegis' ");
                    $delRg = $conect->consulta("DELETE FROM registro WHERE ID_R = '$idRegis' ");
                    
                 }
             }
             
             $selForm = $conect->consulta("SELECT ID_FORM FROM `formulario` WHERE NOMBRE_U ='$idAsesor'");
             $tamForm=mysql_num_rows($selForm);
             
            if($tamForm>0)
            {
                while($fila1 = mysql_fetch_array($selForm))
                {
                    $idForm=$fila1[0];
                    $puntajeG= $conect->consulta("SELECT ID_N FROM nota WHERE ID_FORM ='$idForm'");
                    //var_dump($puntajeG);
                    $idpuntaj=mysql_fetch_array($puntajeG);
                    $delPuntaG = $conect->consulta("DELETE FROM puntaje_ge WHERE ID_N = '$idpuntaj[0]' ");
                    //var_dump($eliminar_puntaje1);
                  
                    $delPunta = $conect->consulta("DELETE FROM puntaje WHERE ID_FORM = '$idForm' ");
                    //var_dump($eliminar_puntaje);
                    $delNota = $conect->consulta("DELETE FROM nota WHERE ID_FORM = '$idForm' ");
                    $delFE= $conect->consulta("DELETE FROM form_crit_e WHERE ID_FORM = '$idForm' ");
                    $delFC= $conect->consulta("DELETE FROM from_crit_c WHERE ID_FORM = '$idForm' ");
                    $selCritC = $conect->consulta("SELECT ID_CRITERIO_C FROM criteriocalificacion WHERE NOMBRE_U = '$idAsesor'");
                    while($rowIDC = mysql_fetch_row($selCritC))
                    {
                        $delIndi = $conect->consulta("DELETE from indicador WHERE ID_CRITERIO_C = '$rowIDC[0]' ");
                    }
                }
                
                    $delForm1= $conect->consulta("DELETE FROM formulario WHERE NOMBRE_U = '$idAsesor' ");  
                
                    $delCc= $conect->consulta("DELETE FROM criteriocalificacion WHERE NOMBRE_U = '$idAsesor'  ");
                    $delCe= $conect->consulta("DELETE FROM criterio_evaluacion WHERE NOMBRE_U = '$idAsesor' ");          
            }
            
           
            $delRol= $conect->consulta("DELETE FROM usuario_rol WHERE NOMBRE_U = '$idAsesor' ");
            $delIns= $conect->consulta("DELETE FROM inscripcion WHERE NOMBRE_UA = '$idAsesor' ");
            $selCritC = $conect->consulta("SELECT ID_CRITERIO_C FROM criteriocalificacion WHERE NOMBRE_U = '$idAsesor'");
            
            while($rowID = mysql_fetch_row($selCritC))
            {
                $delIn = $conect->consulta("DELETE FROM indicador WHERE ID_CRITERIO_C = '$rowID[0]'");
            }
            
            $delCc= $conect->consulta("DELETE FROM criteriocalificacion WHERE NOMBRE_U = '$idAsesor'  ");
            $delCe= $conect->consulta("DELETE FROM criterio_evaluacion WHERE NOMBRE_U = '$idAsesor' "); 
            $delTipo = $conect->consulta("DELETE FROM asesor WHERE NOMBRE_U = '$idAsesor' ");
            
            $delSesion = $conect->consulta("DELETE FROM sesion WHERE NOMBRE_U = '$idAsesor' ");
            $delUser = $conect->consulta("DELETE FROM usuario WHERE NOMBRE_U = '$idAsesor' ");
            
            echo '<script>alert("Se elimino al asesor correctamente!!")</script>';
            echo '<script>window.location="../Vista/lista_asesores.php";</script>';
            
            die();
            
        }//end op--si
        
        if($op == 'no')
        {
            header('location:../Vista/lista_asesores.php');
            die();
        }
         
        die();
    }//end if isset
    
  
     
    if(is_array($regisAse))
    {
        echo '<script>
            var pagina =  "eliminar_asesor.php?id_us='.$idAsesor.'&op=si"
            var pagina2 = "eliminar_asesor.php?id_us='.$idAsesor.'&op=no"
            if(confirm("El asesor tiene registros...desea eliminarlo de todas formas??"))
            {
                location.href = pagina
            }
            else{
                location.href = pagina2
            }
          </script>';
        
        die();
    }
    else
    {
        
        
        
        $selFormS = $conect->consulta("SELECT ID_FORM FROM `formulario` WHERE NOMBRE_U ='$idAsesor'");
        $tamFormS=mysql_num_rows($selFormS);
        if( $tamFormS>0){
            while($fila1 = mysql_fetch_array($selFormS))
            {
                $idForm=$fila1[0];
                $puntajeG= $conect->consulta("SELECT ID_N FROM nota WHERE ID_FORM ='$idForm'");
                //var_dump($puntajeG);
                $idPuntaj=mysql_fetch_array($puntajeG);
                $delPuntjG = $conect->consulta("DELETE FROM puntaje_ge WHERE ID_N = '$idPuntaj[0]' ");
                //var_dump($eliminar_puntaje1);
                echo "</br>";
                $delPuntaj= $conect->consulta("DELETE FROM puntaje WHERE ID_FORM = '$idForm' ");
                //var_dump($eliminar_puntaje);
                $delNota = $conect->consulta("DELETE FROM nota WHERE ID_FORM = '$idForm1' ");
                $delFE= $conect->consulta("DELETE FROM form_crit_e WHERE ID_FORM = '$idForm' ");
                $delFC= $conect->consulta("DELETE FROM from_crit_c WHERE ID_FORM = '$idForm' ");
                $delCritC = $conect->consulta("SELECT ID_CRITERIO_C FROM criteriocalificacion WHERE NOMBRE_U = '$idAsesor'");
                while($rowIDC = mysql_fetch_row($SeleccionarIDCritC))
                {
                    $delIndi = $conect->consulta("DELETE from indicador WHERE ID_CRITERIO_C = '$rowIDC[0]' ");
                }
            }
            $delFormS= $conect->consulta("DELETE FROM formulario WHERE NOMBRE_U = '$idAsesor' ");  
            $delCc= $conect->consulta("DELETE FROM criteriocalificacion WHERE NOMBRE_U = '$$idAsesor'  ");
            $delCe= $conect->consulta("DELETE FROM criterio_evaluacion WHERE NOMBRE_U = '$idAsesor' ");
            $delRol = $conect->consulta("DELETE FROM usuario_rol WHERE NOMBRE_U = '$idAsesor' ");
            $delIns= $conect->consulta("DELETE FROM inscripcion WHERE NOMBRE_UA = '$idAsesor' ");
            $delTipo = $conect->consulta("DELETE FROM asesor WHERE NOMBRE_U = '$idAsesor' ");
            $delSes = $conect->consulta("DELETE FROM sesion WHERE NOMBRE_U = '$$idAsesor' ");
            $delUser = $conect->consulta("DELETE FROM usuario WHERE NOMBRE_U = '$idAsesor' ");
        }
        
        
        
        $delComen = $conect->consulta(" DELETE FROM `comentarios` WHERE NOMBRE_U='$idAsesor'");
        $delNoti = $conect->consulta(" DELETE FROM `noticias` WHERE NOMBRE_U='$idAsesor'");
     
        $delRolU = $conect->consulta("DELETE FROM usuario_rol WHERE NOMBRE_U = '$idAsesor' ");
              
        $delIns = $conect->consulta("DELETE FROM inscripcion WHERE NOMBRE_UA = '$idAsesor' ");
        
        $delCc= $conect->consulta("DELETE FROM criteriocalificacion WHERE NOMBRE_U = '$idAsesor'  ");
     
        $delAsesor = $conect->consulta("DELETE FROM asesor WHERE NOMBRE_U = '$idAsesor' ");
        $delSesion = $conect->consulta("DELETE FROM sesion WHERE NOMBRE_U = '$idAsesor' ");
        
        $delUser = $conect->consulta("DELETE FROM usuario WHERE NOMBRE_U = '$idAsesor' ");
        
        // mysql_close($conexion);
        
        
        echo '<script>alert("Se elimino al asesor correctamente!!")</script>';
    echo '<script>window.location="../Vista/lista_asesores.php";</script>';
    }
         
?>