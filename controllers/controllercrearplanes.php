<?php
require_once '../config/configbd.php';
$con = new mysqli($bd['host'],$bd['user'],$bd['pass'],$bd['data']);
$con->set_charset("utf8");
if(isset($_POST)){
    $uploadedFile = '';
    $fileName = '';
    if(!empty($_FILES["imagen"]["type"])){
        $fileName = time().'_'.$_FILES['imagen']['name'];
        $valid_extensions = array("jpeg", "jpg", "png");
        $temporary = explode(".", $_FILES["imagen"]["name"]);
        $file_extension = end($temporary);
        if((($_FILES["imagen"]["type"] == "image/png") || ($_FILES["imagen"]["type"] == "image/jpg") || ($_FILES["imagen"]["type"] == "image/jpeg")) && in_array($file_extension, $valid_extensions)){
            $sourcePath = $_FILES['imagen']['tmp_name'];
            $targetPath = "../production/images/planes/".$fileName;
            echo $targetPath;
            if(move_uploaded_file($sourcePath,$targetPath)){
                $uploadedFile = $fileName;
            }
        }
    }
    $nombrePlan         = $_POST['nombre'];
    $descripcionPlan    = $_POST['descripcion'];
    $estadoPlan         = $_POST['estado'];
    $contenidoPlan      = $_POST['contenido'];
    $horario            = $_POST['horario'];
    try{
        $sql = "INSERT INTO wp_es_planes(nombre,descripcion,estado,idpublicacion,contenido,urlimage,franjahoraria) 
                    VALUE('$nombrePlan','$descripcionPlan','$estadoPlan',0,'$contenidoPlan','$fileName',$horario)";
        $con->query($sql);
    }catch(Excpetion $err){
        error_log( $err->getMessage() );
    }
    header('Location: ../production/');

}

?>