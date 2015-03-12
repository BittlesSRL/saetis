<?php
    
    $conex = new conexion();
    $cons="SELECT nombre_r FROM registro WHERE tipo_t ='documento requerido' AND nombre_u='$uActivo'";
    
    $a=$conex->consulta($cons);
    
    if(isset($_POST['documentoRequerido'])){
      
        $_a=$_POST['documentoRequerido'];
    }
    else
    {
        $_a="";
    }
       
        $cont=0;
    

?>
