<?php
session_start();
require_once '../config/configbd.php';
$con = new mysqli($bd['host'],$bd['user'],$bd['pass'],$bd['data']);
$con->set_charset("utf8");
date_default_timezone_set('America/Bogota');

if(isset($_POST['action']) && isset($_SESSION['idPerfil']) && !empty($_SESSION['idPerfil'])){
    switch($_POST['action']){
        case "register":
            $nombre     = (isset($_POST['nombre']))? filter_var($_POST['nombre'],FILTER_SANITIZE_STRING):'';
            $apellido   = (isset($_POST['apellido']))?filter_var($_POST['apellido'],FILTER_SANITIZE_STRING):'';
            $telefono   = (isset($_POST['telefono']))?filter_var($_POST['telefono'],FILTER_SANITIZE_STRING):'';
            $email      = (isset($_POST['email']))?filter_var($_POST['email'],FILTER_SANITIZE_EMAIL):'';
            $documento  = (isset($_POST['documento']))?filter_var($_POST['documento'],FILTER_SANITIZE_STRING):'';
            $direccion  = (isset($_POST['direccion']))?filter_var($_POST['direccion'],FILTER_SANITIZE_STRING):'';
            $usuario    = (isset($_POST['usuario']))?filter_var($_POST['usuario'],FILTER_SANITIZE_STRING):'';
            $clave      = (isset($_POST['clave']))?filter_var($_POST['clave'],FILTER_SANITIZE_STRING):'';
            if(!empty($nombre) && !empty($apellido) && !empty($telefono) && !empty($email) && !empty($documento) && !empty($direccion) && !empty($usuario) && !empty($clave)){
                try{
                    $sql = "INSERT INTO wp_es_clientes(nombre,apellido,telefono,direccion,email,clave,asesor,documento) 
                    VALUE('$nombre','$apellido','$telefono','$direccion','$email',MD5('$clave'),'$usuario','$documento')";
                    $con->query($sql);
                    $_SESSION['idCliente'] = $con->insert_id;
                    echo json_encode( array("response"=>'success','mensaje'=> 'Usted se ha registrado con exito' ) );
                }catch(Exception $err){
                    echo json_encode( array("response"=>'fail','mensaje'=> 'Usted se ha registrado con exito' ) );
                }
            }else{
                echo json_encode( array("response"=>'fail','mensaje'=> 'Llene todos los campos del formulario' ) );
            }
        break;
        case "login":
            $usuario    = (isset($_POST['usuario']))?filter_var($_POST['usuario'],FILTER_SANITIZE_STRING):'';
            $clave      = (isset($_POST['clave']))?filter_var($_POST['clave'],FILTER_SANITIZE_STRING):'';
            $sql        = "SELECT id FROM wp_es_usuarios where usuario='".$usuario."' AND clave=MD5('".$clave."') AND estado='A'";
            $result     = $con->query($sql);
            if($result->num_rows>=1){
                $row = $result->fetch_assoc();
                $_SESSION['idCliente']     = $row['id'];
                echo json_encode( array("response"=>'success','mensaje'=> 'Sesion Iniciada' ) );
            }else{
                echo json_encode( array("response"=>'fail','mensaje'=> 'Usuario o clave invalidos' ) );
            }
            
        break;
        case "crearcliente":
            $nombre     = (isset($_POST['nombre']))? filter_var($_POST['nombre'],FILTER_SANITIZE_STRING):'';
            $apellido   = (isset($_POST['apellido']))?filter_var($_POST['apellido'],FILTER_SANITIZE_STRING):'';
            $telefono   = (isset($_POST['telefono']))?filter_var($_POST['telefono'],FILTER_SANITIZE_STRING):'';
            $email      = (isset($_POST['email']))?filter_var($_POST['email'],FILTER_SANITIZE_EMAIL):'';
            $documento  = (isset($_POST['documento']))?filter_var($_POST['documento'],FILTER_SANITIZE_STRING):'';
            $direccion  = (isset($_POST['direccion']))?filter_var($_POST['direccion'],FILTER_SANITIZE_STRING):'';
            $pais       = (isset($_POST['paises']))?filter_var($_POST['paises'],FILTER_SANITIZE_NUMBER_INT):'';
            $ciudad     = (isset($_POST['ciudad']))?filter_var($_POST['ciudad'],FILTER_SANITIZE_STRING):'';
            $clave      = (isset($_POST['clave']))?filter_var($_POST['clave'],FILTER_SANITIZE_STRING):'';
            if(!empty($nombre) && !empty($apellido) && !empty($telefono) && !empty($email) && !empty($documento) && !empty($direccion) && !empty($clave) && is_numeric($pais) && !empty($ciudad)){
                try{
                    $sql = "SELECT id FROM wp_es_clientes WHERE documento='".$documento."' OR email='".$email."'";
                    $result = $con->query($sql);
                    if($result->num_rows>=1){
                        echo json_encode( array("response"=>'fail','mensaje'=> 'El documento o el email ya existen, debe cambiarlo.' ) );
                    }else{
                        $usuario = $_SESSION['idUser'];
                        $sql = "INSERT INTO wp_es_clientes(nombre,apellido,telefono,direccion,email,clave,asesor,documento,pais,ciudad) 
                        VALUE('$nombre','$apellido','$telefono','$direccion','$email',MD5('$clave'),'$usuario','$documento',$pais,'$ciudad')";
                        $con->query($sql);
                        echo json_encode( array("response"=>'success','mensaje'=> 'Usuario creado con exito','id'=>$con->insert_id ) );
                    }
                }catch(Exception $err){
                    echo json_encode( array("response"=>'fail','mensaje'=> 'Error al grabar usuario. '.$err->getMessage() ) );
                }
            }else{
                echo json_encode( array("response"=>'fail','mensaje'=> 'Llene todos los campos del formulario' ) );
            }
        break;
        case "actualizar":
            $nombre     = (isset($_POST['nombre']))? filter_var($_POST['nombre'],FILTER_SANITIZE_STRING):'';
            $apellido   = (isset($_POST['apellido']))?filter_var($_POST['apellido'],FILTER_SANITIZE_STRING):'';
            $telefono   = (isset($_POST['telefono']))?filter_var($_POST['telefono'],FILTER_SANITIZE_STRING):'';
            $email      = (isset($_POST['email']))?filter_var($_POST['email'],FILTER_SANITIZE_EMAIL):'';
            $documento  = (isset($_POST['documento']))?filter_var($_POST['documento'],FILTER_SANITIZE_STRING):'';
            $direccion  = (isset($_POST['direccion']))?filter_var($_POST['direccion'],FILTER_SANITIZE_STRING):'';
            $clave      = (isset($_POST['clave']))?filter_var($_POST['clave'],FILTER_SANITIZE_STRING):'';
            $pais       = (isset($_POST['paises']))?filter_var($_POST['paises'],FILTER_SANITIZE_NUMBER_INT):'';
            $ciudad     = (isset($_POST['ciudad']))?filter_var($_POST['ciudad'],FILTER_SANITIZE_STRING):'';
            $id      = (isset($_POST['id']))?$_POST['id']:'';
            if(!empty($nombre) && !empty($apellido) && !empty($telefono) && !empty($email) && !empty($documento) && !empty($direccion) && is_numeric($pais) && !empty($ciudad)){
                try{
                    $sql = "SELECT id FROM wp_es_clientes WHERE id <> $id AND (documento='".$documento."' OR email='".$email."')";
                    $result = $con->query($sql);
                    if($result->num_rows>=1){
                        echo json_encode( array("response"=>'fail','mensaje'=> 'El documento o el email ya existen, debe cambiarlo.' ) );
                    }else{
                        if(!empty($clave)){
                            $sql = "UPDATE wp_es_clientes SET nombre='$nombre',apellido='$apellido',telefono='$telefono',direccion='$direccion',email='$email',documento='$documento',clave=MD5('$clave'),pais=$pais,ciudad='$ciudad' WHERE id=".$id;
                            echo json_encode( array("response"=>'success','mensaje'=> 'Usuario actualizado con exito, Para ver los cambios recarge la pagina' ) );
                        }else{
                            try{
                                $sql = "UPDATE wp_es_clientes SET nombre='$nombre',apellido='$apellido',telefono='$telefono',direccion='$direccion',email='$email',documento='$documento',pais=$pais,ciudad='$ciudad' WHERE id=".$id;
                                $result = $con->query($sql);
                                echo json_encode( array("response"=>'success','mensaje'=> 'Usuario actualizado con exito, Para ver los cambios recarge la pagina' ) );
                            }catch(Exception $err){
                                echo json_encode( array("response"=>'fail','mensaje'=> 'Error al grabar usuario. '.$err->getMessage() ) );
                            }
                        }
                    }
                }catch(Exception $err){
                    echo json_encode( array("response"=>'fail','mensaje'=> 'Error al grabar usuario. '.$err->getMessage() ) );
                }
            }else{
                echo json_encode( array("response"=>'fail','mensaje'=> 'Llene todos los campos del formulario' ) );
            }
        break;
        case "crearusuario":
            $usuario    = (isset($_POST['usuario']))? filter_var($_POST['usuario'],FILTER_SANITIZE_STRING):'';
            $nombre     = (isset($_POST['nombre']))?filter_var($_POST['nombre'],FILTER_SANITIZE_STRING):'';
            $email      = (isset($_POST['email']))?filter_var($_POST['email'],FILTER_SANITIZE_EMAIL):'';
            $clave      = (isset($_POST['clave']))?filter_var($_POST['clave'],FILTER_SANITIZE_STRING):'';
            $estado     = (isset($_POST['estado']))?filter_var($_POST['estado'],FILTER_SANITIZE_STRING):'';
            $perfil     = (isset($_POST['perfil']))?filter_var($_POST['perfil'],FILTER_SANITIZE_NUMBER_INT):'';
            if(!empty($usuario) && !empty($nombre) && !empty($email) && !empty($estado) && is_numeric($perfil)){
                $sql = "SELECT id FROM wp_es_usuarios WHERE usuario='$usuario'";
                $result = $con->query($sql);
                if($result->num_rows>=1){
                    echo json_encode( array("response"=>'fail','mensaje'=> 'El usuario ya existe' ) );
                }else{
                    $sql = "INSERT INTO wp_es_usuarios(usuario,nombre,email,clave,estado,perfil,documento) 
                            VALUE('$usuario','$nombre','$email',MD5('$clave'),'$estado',$perfil,'0')";
                    $con->query($sql);
                    echo json_encode( array("response"=>'success','mensaje'=> 'Usuario creado con exito' ) );
                }
            }else{
                echo json_encode( array("response"=>'fail','mensaje'=> 'Llene todos los campos del formulario' ) );
            }
        break;
        case "edit_usuario":
            $usuario    = (isset($_POST['usuario']))? filter_var($_POST['usuario'],FILTER_SANITIZE_STRING):'';
            $nombre     = (isset($_POST['nombre']))?filter_var($_POST['nombre'],FILTER_SANITIZE_STRING):'';
            $email      = (isset($_POST['email']))?filter_var($_POST['email'],FILTER_SANITIZE_EMAIL):'';
            $estado     = (isset($_POST['estado']))?filter_var($_POST['estado'],FILTER_SANITIZE_STRING):'';
            $perfil     = (isset($_POST['perfil']))?filter_var($_POST['perfil'],FILTER_SANITIZE_NUMBER_INT):'';
            $id         = (isset($_POST['id']))?filter_var($_POST['id'],FILTER_SANITIZE_NUMBER_INT):'';
            $clave      = (isset($_POST['clave']))?filter_var($_POST['clave'],FILTER_SANITIZE_STRING):'';
            if(!empty($usuario) && !empty($nombre) && !empty($email) && !empty($estado) && is_numeric($perfil)){
                if(!empty($clave)){
                    $sql = "UPDATE wp_es_usuarios SET usuario='$usuario',nombre='$nombre',email='$email',estado='$estado',perfil=$perfil,clave=MD5('$clave') WHERE id=$id";
                }else{
                    $sql = "UPDATE wp_es_usuarios SET usuario='$usuario',nombre='$nombre',email='$email',estado='$estado',perfil=$perfil WHERE id=$id";
                }
                $con->query($sql);
                echo json_encode( array("response"=>'success','mensaje'=> 'Usuario actualizado con exito' ) );
            }else{
                echo json_encode( array("response"=>'fail','mensaje'=> 'Llene todos los campos del formulario' ) );
            }
        break;
        case "edit_plan":
            $nombre         = (isset($_POST['nombre']))?filter_var($_POST['nombre'],FILTER_SANITIZE_STRING):'';
            $descripcion    = (isset($_POST['descripcion']))?filter_var($_POST['descripcion'],FILTER_SANITIZE_STRING):'';
            $estado         = (isset($_POST['estado']))?filter_var($_POST['estado'],FILTER_SANITIZE_STRING):'';
            $contenido      = (isset($_POST['contenido']))?filter_var($_POST['contenido'],FILTER_SANITIZE_STRING):'';
            $id             = (isset($_POST['id']))?filter_var($_POST['id'],FILTER_SANITIZE_NUMBER_INT):'';
            $horario        = (isset($_POST['horario']))?filter_var($_POST['horario'],FILTER_SANITIZE_NUMBER_INT):'';

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
                    if(move_uploaded_file($sourcePath,$targetPath)){
                        $uploadedFile = $fileName;
                    }
                }
            }
            
            if(!empty($nombre) && !empty($descripcion) && !empty($estado)){
                if(!empty($fileName)){
                    $sql = "UPDATE wp_es_planes SET nombre='$nombre',descripcion='$descripcion',estado='$estado',contenido='$contenido',urlimage='$uploadedFile',franjahoraria=$horario WHERE id=$id";
                }else{
                    $sql = "UPDATE wp_es_planes SET nombre='$nombre',descripcion='$descripcion',estado='$estado',contenido='$contenido',franjahoraria=$horario WHERE id=$id";
                }
                $con->query($sql);
                echo json_encode( array("response"=>'success','mensaje'=> 'Plan actualizado con exito' ) );
            }else{
                echo json_encode( array("response"=>'fail','mensaje'=> 'Llene todos los campos del formulario' ) );
            }
        break;
        case "grabar_perfil":
            $nombre         = (isset($_POST['nombre']))?filter_var($_POST['nombre'],FILTER_SANITIZE_STRING):'';
            $estado         = (isset($_POST['estado']))?filter_var($_POST['estado'],FILTER_SANITIZE_STRING):'';
            $id             = (isset($_POST['idperfil']))?filter_var($_POST['idperfil'],FILTER_SANITIZE_NUMBER_INT):0;
            if(!empty($nombre) && !empty($estado)){
                if($id>0){
                    $sql = "UPDATE wp_es_perfiles SET nombre='$nombre',estado='$estado' WHERE id=$id";
                    $con->query($sql);
                    echo json_encode( array("response"=>'success','mensaje'=> 'Perfil actualizado con exito' ) );
                }else{
                    $sql = "SELECT id,nombre,estado FROM wp_es_perfiles WHERE nombre='$nombre'";
                    $result = $con->query($sql);
                    if($result->num_rows>=1){
                        echo json_encode( array("response"=>'fail','mensaje'=> 'Ya existe un perfil con este nombre' ) );
                    }else{
                        $sql = "INSERT INTO wp_es_perfiles(nombre,descripcion,estado) VALUE('$nombre','','$estado')";
                        $con->query($sql);
                        echo json_encode( array("response"=>'success','mensaje'=> 'Perfil grabado con exito' ) );
                    }
                }
            }else{
                echo json_encode( array("response"=>'fail','mensaje'=> 'Llene todos los campos del formulario' ) );
            }
        break;
        case "edit_permisos":
            $perfil     = (isset($_POST['perfil']))?filter_var($_POST['perfil'],FILTER_SANITIZE_NUMBER_INT):0;
            $max        = (isset($_POST['max']))?filter_var($_POST['max'],FILTER_SANITIZE_NUMBER_INT):0;
            if($perfil==10){
                echo json_encode( array("response"=>'fail','mensaje'=> 'A este perfil no se le pueden cambiar los permisos' ) );
            }else{
                try{
                    for($i=1;$i<=$max;$i++){
                        $val = (isset($_POST[$i]))?$_POST[$i]:0;
                        $sql = "SELECT id FROM wp_es_permisos WHERE perfil=$perfil AND modulo=$i";
                        $result = $con->query($sql);
                        if($result->num_rows>=1){
                            $sql = "UPDATE wp_es_permisos SET permiso=".$val." WHERE perfil=$perfil AND modulo=".$i;
                        }else{
                            $sql = "INSERT INTO wp_es_permisos(perfil,modulo,permiso) VALUE($perfil,$i,$val)";
                        }
                        $con->query($sql);
                    }
                    echo json_encode( array("response"=>'success','mensaje'=> 'Perfil actualizado con exito' ) );
                }catch(Exception $err){
                    echo json_encode( array("response"=>'fail','mensaje'=> 'No se pudo grabar los permisos' ) );
                }
            }
            
        break;
        case "crearbote":
            if(isset($_SESSION['permisos'][16]) && $_SESSION['permisos'][16]==1){
                $nombre     = (isset($_POST['nombre']))?filter_var($_POST['nombre'],FILTER_SANITIZE_STRING):'';
                $estado     = (isset($_POST['estado']))?filter_var($_POST['estado'],FILTER_SANITIZE_STRING):'';
                $pasajeros  = (isset($_POST['pasajeros']))?filter_var($_POST['pasajeros'],FILTER_SANITIZE_NUMBER_INT):0;
                $tripulante = (isset($_POST['tripulante']))?filter_var($_POST['tripulante'],FILTER_SANITIZE_NUMBER_INT):0;
                if(!empty($nombre) && !empty($estado) && $pasajeros>0 && $tripulante>0){
                    $sql = "SELECT id FROM wp_es_botes WHERE nombre='$nombre'";
                    $result = $con->query($sql);
                    if($result->num_rows>=1){
                        echo json_encode( array("response"=>'fail','mensaje'=> 'No puede crear un bote con este nombre' ) );
                    }else{
                        $sql = "INSERT INTO wp_es_botes(nombre,pasajeros,tripulantes,estado,idpublicacion) VALUE('$nombre',$pasajeros,$tripulante,'$estado',0)";
                        $con->query($sql);
                        echo json_encode( array("response"=>'success','mensaje'=> 'Bote grabado con exito' ) );
                    }
                }else{
                    echo json_encode( array("response"=>'fail','mensaje'=> 'Llene todos los campos del formulario' ) );
                }
            }else{
                echo json_encode( array("response"=>'fail','mensaje'=> 'No tiene permisos para realizar esta operación' ) );
            }
        break;
        case "editarbote":
            if(isset($_SESSION['permisos'][16]) && $_SESSION['permisos'][16]==1){
                $nombre     = (isset($_POST['nombre']))?filter_var($_POST['nombre'],FILTER_SANITIZE_STRING):'';
                $estado     = (isset($_POST['estado']))?filter_var($_POST['estado'],FILTER_SANITIZE_STRING):'';
                $pasajeros  = (isset($_POST['pasajeros']))?filter_var($_POST['pasajeros'],FILTER_SANITIZE_NUMBER_INT):0;
                $tripulante = (isset($_POST['tripulantes']))?filter_var($_POST['tripulantes'],FILTER_SANITIZE_NUMBER_INT):0;
                $id         = (isset($_POST['id']))?filter_var($_POST['id'],FILTER_SANITIZE_NUMBER_INT):0;
                if(!empty($nombre) && !empty($estado) && $pasajeros>0 && $tripulante>0){
                    $sql = "SELECT id FROM wp_es_botes WHERE nombre='$nombre'";
                    $result = $con->query($sql);
                    if($result->num_rows>=1){

                        $uploadedFile = '';
                        $fileName = '';
                        if(!empty($_FILES["imagen"]["type"])){
                            $fileName = time().'_'.$_FILES['imagen']['name'];
                            $valid_extensions = array("jpeg", "jpg", "png");
                            $temporary = explode(".", $_FILES["imagen"]["name"]);
                            $file_extension = end($temporary);
                            if((($_FILES["imagen"]["type"] == "image/png") || ($_FILES["imagen"]["type"] == "image/jpg") || ($_FILES["imagen"]["type"] == "image/jpeg")) && in_array($file_extension, $valid_extensions)){
                                $sourcePath = $_FILES['imagen']['tmp_name'];
                                $targetPath = "../production/images/botes/".$fileName;
                                if(move_uploaded_file($sourcePath,$targetPath)){
                                    $uploadedFile = $fileName;
                                }
                            }
                        }
                        if(!empty($fileName)){
                            $sql = "UPDATE wp_es_botes SET nombre='$nombre',pasajeros=$pasajeros,tripulantes=$tripulante,estado='$estado',urlimage='$fileName' WHERE id=$id";
                        }else{
                            $sql = "UPDATE wp_es_botes SET nombre='$nombre',pasajeros=$pasajeros,tripulantes=$tripulante,estado='$estado' WHERE id=$id";
                        }
                        $con->query($sql);
                        echo json_encode( array("response"=>'success','mensaje'=> 'Bote grabado con exito' ) );
                        
                    }else{
                        echo json_encode( array("response"=>'fail','mensaje'=> 'No se puede actualizar bote' ) );
                    }
                }else{
                    echo json_encode( array("response"=>'fail','mensaje'=> 'Llene todos los campos del formulario' ) );
                }
            }else{
                echo json_encode( array("response"=>'fail','mensaje'=> 'No tiene permisos para realizar esta operación' ) );
            }
        break;
        case "crear_precio_bote_plan":
            $bote   = (isset($_POST['botes']))?filter_var($_POST['botes'],FILTER_SANITIZE_NUMBER_INT):0;
            $plan   = (isset($_POST['planes']))?filter_var($_POST['planes'],FILTER_SANITIZE_NUMBER_INT):0;
            $precio = (isset($_POST['precio']))?filter_var($_POST['precio'],FILTER_SANITIZE_NUMBER_FLOAT):0;
            if($bote>0 && $plan>0 && $precio>0){
                $sql = "SELECT id FROM wp_es_valores_planes_botes WHERE idplan=$plan AND idbote=$bote";
                    $result = $con->query($sql);
                    if($result->num_rows>=1){
                        echo json_encode( array("response"=>'fail','mensaje'=> 'Este bote asociado a este plan ya tiene un precio.' ) );
                    }else{
                        $sql = "INSERT INTO wp_es_valores_planes_botes(idplan,idbote,precio,estado) VALUE($plan,$bote,$precio,'A')";
                        $con->query($sql);
                        echo json_encode( array("response"=>'success','mensaje'=> 'Precio grabado con exito' ) );
                    }
            }else{
                echo json_encode( array("response"=>'fail','mensaje'=> 'Llene todos los campos del formulario' ) );
            }
        break;
        case "editar_precio_bote_plan":
            $id     = (isset($_POST['id']))?filter_var($_POST['id'],FILTER_SANITIZE_NUMBER_INT):0;
            $precio = (isset($_POST['precio']))?filter_var($_POST['precio'],FILTER_SANITIZE_NUMBER_FLOAT):0;
            if($id>0 && $precio>0){
                $sql = "SELECT id FROM wp_es_valores_planes_botes WHERE id=$id";
                $result = $con->query($sql);
                if($result->num_rows>=1){
                    $sql = "UPDATE wp_es_valores_planes_botes SET precio=$precio WHERE id=$id";
                    $con->query($sql);
                    echo json_encode( array("response"=>'success','mensaje'=> 'Precio grabado con exito' ) );
                }else{
                    echo json_encode( array("response"=>'fail','mensaje'=> 'No se encontro precio, para este bote con este plan.' ) );
                }
            }else{
                echo json_encode( array("response"=>'fail','mensaje'=> 'Llene todos los campos del formulario' ) );
            }
        break;
        case "crear_catering":
            $nombre         = (isset($_POST['nombre']))?filter_var($_POST['nombre'],FILTER_SANITIZE_STRING):'';
            $descripcion    = (isset($_POST['descripcion']))?filter_var($_POST['descripcion'],FILTER_SANITIZE_STRING):'';
            $precio         = (isset($_POST['precio']))?filter_var($_POST['precio'],FILTER_SANITIZE_NUMBER_FLOAT):0;
            $estado         = (isset($_POST['estado']))?filter_var($_POST['estado'],FILTER_SANITIZE_STRING):'';
            if(!empty($nombre) && !empty($descripcion) && !empty($estado) && $precio>0){
                $sql = "SELECT id FROM wp_es_adicionales WHERE nombre='$nombre'";
                $result = $con->query($sql);
                if($result->num_rows>=1){
                    echo json_encode( array("response"=>'fail','mensaje'=> 'Ya existe un catering con este nombre.' ) );
                }else{
                    $sql = "INSERT INTO wp_es_adicionales(nombre,descipcion,precio,estado) VALUE('$nombre','$descripcion',$precio,'$estado')";
                    $con->query($sql);
                    echo json_encode( array("response"=>'success','mensaje'=> 'Catering grabado con exito. ' ) );
                }
            }else{
                echo json_encode( array("response"=>'fail','mensaje'=> 'Llene todos los campos del formulario' ) );
            }
        break;
        case "editar_catering":
            $id             = (isset($_POST['id']))?filter_var($_POST['id'],FILTER_SANITIZE_NUMBER_INT):0;
            $nombre         = (isset($_POST['nombre']))?filter_var($_POST['nombre'],FILTER_SANITIZE_STRING):'';
            $descripcion    = (isset($_POST['descripcion']))?filter_var($_POST['descripcion'],FILTER_SANITIZE_STRING):'';
            $precio         = (isset($_POST['precio']))?filter_var($_POST['precio'],FILTER_SANITIZE_NUMBER_FLOAT):0;
            $estado         = (isset($_POST['estado']))?filter_var($_POST['estado'],FILTER_SANITIZE_STRING):'';
            if(!empty($nombre) && !empty($descripcion) && !empty($estado) && $precio>0){
                $sql = "SELECT id FROM wp_es_adicionales WHERE nombre='$nombre'";
                $result = $con->query($sql);
                if($result->num_rows>=1){

                    $uploadedFile = '';
                    $fileName = '';
                    if(!empty($_FILES["imagen"]["type"])){
                        $fileName = time().'_'.$_FILES['imagen']['name'];
                        $valid_extensions = array("jpeg", "jpg", "png");
                        $temporary = explode(".", $_FILES["imagen"]["name"]);
                        $file_extension = end($temporary);
                        if((($_FILES["imagen"]["type"] == "image/png") || ($_FILES["imagen"]["type"] == "image/jpg") || ($_FILES["imagen"]["type"] == "image/jpeg")) && in_array($file_extension, $valid_extensions)){
                            $sourcePath = $_FILES['imagen']['tmp_name'];
                            $targetPath = "../production/images/catering/".$fileName;
                            if(move_uploaded_file($sourcePath,$targetPath)){
                                $uploadedFile = $fileName;
                            }
                        }
                    }
                    if(!empty($fileName)){
                        $sql = "UPDATE wp_es_adicionales SET nombre='$nombre',descipcion='$descripcion',precio=$precio,estado='$estado',urlimage='$fileName' WHERE id=$id";
                    }else{
                        $sql = "UPDATE wp_es_adicionales SET nombre='$nombre',descipcion='$descripcion',precio=$precio,estado='$estado' WHERE id=$id";
                    }
                    $con->query($sql);
                    echo json_encode( array("response"=>'success','mensaje'=> 'Catering grabado con exito. ' ) );
                }else{
                    echo json_encode( array("response"=>'fail','mensaje'=> 'No existe un catering.' ) );
                }
            }else{
                echo json_encode( array("response"=>'fail','mensaje'=> 'Llene todos los campos del formulario' ) );
            }
        break;
        case "cargar_bote_reserva":
            $plan       = (isset($_POST['plan']))?filter_var($_POST['plan'],FILTER_SANITIZE_NUMBER_INT):0;
            $fecha      = (isset($_POST['fecha']))?filter_var($_POST['fecha'],FILTER_SANITIZE_STRING):0;
            $pasajeros  = (isset($_POST['pasajeros']))?filter_var($_POST['pasajeros'],FILTER_SANITIZE_NUMBER_INT):0;
            if(!empty($fecha) && $plan>0 && $pasajeros>0){
                $_SESSION['pasajeros'] = $pasajeros;
                $_SESSION['fecha'] = $fecha;
                $tmp = explode("/",$fecha);
                $fecha = $tmp[2].'-'.$tmp[1].'-'.$tmp[0];
                $sql = "SELECT b.id FROM wp_es_botes b INNER JOIN wp_es_solution_shedule s ON(b.id=s.idbote AND DATE(s.startdate) = DATE('$fecha') AND s.estado='A') INNER JOIN wp_es_planes p ON(s.idplan=p.id AND franjahoraria=(SELECT franjahoraria FROM wp_es_planes WHERE id=$plan))";
                $result = $con->query($sql);
                $arrayBotesNoDisponible = array();
                if($result->num_rows>=1){
                    while($item = $result->fetch_assoc()){
                        $arrayBotesNoDisponible[] = intval($item['id']);
                    }
                }
                $sql = "SELECT b.id,b.nombre,vpb.precio FROM wp_es_botes b INNER JOIN wp_es_valores_planes_botes vpb ON(b.id=vpb.idbote AND vpb.idplan=$plan) WHERE b.estado='A' AND b.pasajeros >= $pasajeros";
                $result = $con->query($sql);
                $arrayBotes = array();
                $_SESSION['reserva'] = 0;
                if($result->num_rows>=1){
                    while($item = $result->fetch_assoc()){
                        $idBote = intval($item['id']);
                        if(isset($arrayBotesNoDisponible) && count($arrayBotesNoDisponible)>0){
                            if(!in_array($idBote,$arrayBotesNoDisponible)){
                                if(isset($_POST['subaction']) && $_POST['subaction']=="subaction"){
                                    if($_POST['botes']==$idBote){
                                        $_SESSION['reserva'] = $item['precio'];
                                        $_SESSION['bote'] = $item['nombre'];
                                    }else{
                                    }
                                }else{
                                    if($_POST['botes']==$idBote){
                                        $_SESSION['reserva'] = $item['precio'];
                                        $_SESSION['bote'] = $item['nombre'];
                                    }else{
                                        if($_SESSION['reserva']==0){
                                            $_SESSION['bote'] = $item['nombre'];
                                            $_SESSION['reserva'] = $item['precio'];
                                        }
                                    }
                                }
                                $arrayBotes[] = array('id' => $idBote,'nombre'=>$item['nombre'],'precio'=>$item['precio']);
                            }else{
                            }
                        }else{
                            if(isset($_POST['subaction']) && $_POST['subaction']=="subaction"){
                                if($_POST['botes']==$idBote){
                                    $_SESSION['reserva'] = $item['precio'];
                                    $_SESSION['bote'] = $item['nombre'];
                                }
                            }else{
                                if($_SESSION['reserva']==0){
                                    $_SESSION['bote'] = $item['nombre'];
                                    $_SESSION['reserva'] = $item['precio'];
                                }
                            }
                            $arrayBotes[] = array('id' => $idBote,'nombre'=>$item['nombre'],'precio'=>$item['precio']);
                        }
                    }
                }
                echo json_encode( array("response"=>'success','mensaje'=> 'Informaci&oacute;n cargada con exito. ','data'=>$arrayBotes ) );
            }else{
                echo json_encode( array("response"=>'fail','mensaje'=> 'Llene todos los campos del formulario' ) );
            }
        break;
        case "load_resumen_admin":
            $total_base = (isset($_SESSION['reserva']))?$_SESSION['reserva']:0;
            $fecha      = (isset($_SESSION['fecha']))?$_SESSION['fecha']:'';
            $pasajeros  = (isset($_SESSION['pasajeros']))?$_SESSION['pasajeros']:0;
            $bote       = (isset($_SESSION['bote']))?$_SESSION['bote']:'';
            $html = '
            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <h3><span>RESUMEN</span></h3>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div id="resm_fecha">
                        <div class="col-lg-5 col-md-4 col-sm-4 col-xs-4">
                            <span>Fecha de Partida:</span>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <span>'.$fecha.'</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div id="resm_pasajeros">
                        <div class="col-lg-5 col-md-4 col-sm-4 col-xs-4">
                            <span>Pasajeros:</span>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <span>'.$pasajeros.'</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div id="resm_pasajeros">
                        <div class="col-lg-5 col-md-4 col-sm-4 col-xs-4">
                            <span>Bote:</span>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <span>'.$bote.'</span>
                        </div>
                    </div>
                </div>';
                $catering = '';
                $valcat = 0;
                foreach($_SESSION['catering'] as $item){
                    $nombre = $item['nombre'].' X'.$item['cant'];
                    $catering = $catering. '
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div id="resm_catering">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <span>'.$nombre.'</span>
                            </div>
                        </div>
                    </div>';
                    $valcat = $valcat + ($item['cant']*$item['precio']);
                }
                $total_base = number_format($total_base + $valcat,0,'.',',');
                $html = $html.$catering.'
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div id="resm_catering">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <h3><span>Total</span></h3>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <h3><span>$'.$total_base.'</span></h3>
                        </div>
                    </div>
                </div>
            </div>';
            echo json_encode( array("response"=>'success','mensaje'=> 'Informaci&oacute;n cargada con exito. ','html'=>$html ) );
        break;
        case "modificar_catering":
            if(isset($_POST['id'])){
                if($_POST['val']==0 && isset($_SESSION['catering'][$_POST['id']]) ){
                    unset($_SESSION['catering'][$_POST['id']]);
                }else{
                    $_SESSION['catering'][$_POST['id']]=array('nombre'=>$_POST['nombre'],'precio'=>$_POST['precio'],'cant'=>$_POST['val'],'id'=>$_POST['id']);
                }
            }
            echo json_encode( array("response"=>'success','mensaje'=> 'Exito') );
        break;
        case "crear_reserva":
            $plan       = (isset($_POST['planes']))?filter_var($_POST['planes'],FILTER_SANITIZE_NUMBER_INT):'';
            $fecha      = (isset($_POST['fecha']))? filter_var($_POST['fecha'],FILTER_SANITIZE_STRING):'';
            $pasajeros  = (isset($_POST['pasajeros']))?filter_var($_POST['pasajeros'],FILTER_SANITIZE_NUMBER_INT):'';
            $documento  = (isset($_POST['documento']))?filter_var($_POST['documento'],FILTER_SANITIZE_STRING):'';
            $bote       = (isset($_POST['botes']))?filter_var($_POST['botes'],FILTER_SANITIZE_NUMBER_INT):'';
            $asesor     = (isset($_POST['asesor']))?filter_var($_POST['asesor'],FILTER_SANITIZE_NUMBER_INT):'';
            $desc       = (isset($_POST['desc']))? filter_var($_POST['desc'],FILTER_SANITIZE_STRING):'';
            if( empty($asesor) ){
                $asesor = $_SESSION['idUser'];
            }
            if(!empty($documento)){
                $cliente = getCliente($con,$documento);
            }else{
                $cliente    = (isset($_POST['cliente']))?filter_var($_POST['cliente'],FILTER_SANITIZE_NUMBER_INT):0;
            }
            $ftemp      = explode("/",$fecha);
            $fecha      = $ftemp[2].'-'.$ftemp[1].'-'.$ftemp[0];
            if($cliente>0){
                if(!empty($fecha) && is_numeric($plan) && is_numeric($pasajeros)){
                    if( isBoteDisponible($con,$fecha,$bote,$plan) ){
                        $idAgenda = guardarAgenda($con,$fecha,$pasajeros,$plan,$bote,$cliente,$asesor,$desc);
                        if(isset($idAgenda) && is_numeric($idAgenda) && $idAgenda>0){
                            generarFacturacion($con,$bote,$plan,$fecha,$idAgenda,$desc);
                            echo json_encode( array("response"=>'success','mensaje'=> 'Reserva grabada con exito.','id'=>$con->insert_id ) );
                        }else{
                            echo json_encode( array("response"=>'fail','mensaje'=> 'No se pudo guardar la reserva' ) );
                        }
                    }else{
                        echo json_encode( array("response"=>'fail','mensaje'=> 'El bote seleccionado no se encuentra disponible' ) );
                    }
                }
            }else{
                echo json_encode( array("response"=>'fail','mensaje'=> 'No existe cliente con ese numero de documento' ) );
            }
        break;
        case "eliminar_cliente":
            $id = (isset($_POST['id']))?filter_var($_POST['id'],FILTER_SANITIZE_NUMBER_INT):0;
            if($id>0){
                $sql = "DELETE FROM wp_es_clientes WHERE id=$id";
                $con->query($sql);
                echo json_encode( array("response"=>'success','mensaje'=> 'Cliente eliminado con exito. ' ) );
            }else{
                echo json_encode( array("response"=>'fail','mensaje'=> 'No existe un catering.' ) );
            }
        break;
        case "eliminar_reserva":
            $id     = (isset($_POST['id']))?filter_var($_POST['id'],FILTER_SANITIZE_NUMBER_INT):0;
            if($id>0){
                $sql = "UPDATE wp_es_solution_shedule SET estado='I' WHERE id=$id";
                $con->query($sql);
                $sql = "UPDATE wp_es_orden SET estado='I' WHERE reserva=$id";
                $con->query($sql);
                $sql = "UPDATE wp_es_ordendetalle SET estado='I' WHERE idorden = (SELECT id FROM wp_es_orden WHERE reserva=$id)";
                $con->query($sql);
                echo json_encode( array("response"=>'success','mensaje'=> 'Reserva anulada con exito. ' ) );
            }else{
                echo json_encode( array("response"=>'fail','mensaje'=> 'No existe esta reserva.' ) );
            }
        break;
        case "load_abonos":
            $id = (isset($_POST['id']))?filter_var($_POST['id'],FILTER_SANITIZE_NUMBER_INT):0;
            if($id>0){
                $sql    = "SELECT id FROM wp_es_orden WHERE reserva=$id";
                $result = $con->query($sql);
                $item   = $result->fetch_assoc();
                $idOrden = $item['id'];
                $sql    = "SELECT a.id,a.abono,DATE(a.fecha) AS fecha,a.estado FROM wp_es_abonos a INNER JOIN wp_es_orden o ON(a.idorden=o.id AND o.reserva=$id)";
                $result = $con->query($sql);
                $body = '';
                $total = 0;
                if($result->num_rows>=1){
                    while($row = $result->fetch_assoc()){
                        $btn = '';
                        switch($row['estado']){
                            case 'A':
                                $btn = '<button type="button" data-id="'.$row['id'].'" class="btn btn-primary btn_aprobar_abono">Aprobar</button>';
                            break;
                            case 'B':
                                $btn = 'Aprobado';
                            break;
                        }
                        $tmp = explode("-",$row['fecha']);
                        $fecha = $tmp[2].'/'.$tmp[1].'/'.$tmp[0];
                        $body = $body."<tr>
                        <td>$".number_format($row['abono'],0,".",",")."</td>
                        <td>".$fecha."</td>
                        <td>".getEstadoAbono($row['estado'])."</td>
                        <td>$btn</td>
                      </tr>";
                    }
                }
                $html = '<input type="hidden" id="idOrdenAbondo" value="'.$idOrden.'" />
                <table id="datatable" class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th>Abono</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>Acci&oacute;n</th>
                  </tr>
                </thead>
                <tbody>
                  '.$body.'
                </tbody>
              </table>';
                echo json_encode( array("response"=>'success','mensaje'=> 'Datos obtenidos. ','html'=>$html ) );
            }else{
                echo json_encode( array("response"=>'fail','mensaje'=> 'No existe esta reserva.' ) );
            }
        break;
        case "add_abono":
            $id     = (isset($_POST['id']))?filter_var($_POST['id'],FILTER_SANITIZE_NUMBER_INT):0;
            $valor  = (isset($_POST['valor']))?filter_var($_POST['valor'],FILTER_SANITIZE_NUMBER_FLOAT):0;
            $fecha  = date('Y-m-d H:i:i');
            $sql = "INSERT INTO wp_es_abonos(abono,fecha,estado,idorden) VALUE($valor,'$fecha','A',$id)";
            $con->query($sql);
            echo json_encode( array("response"=>'success','mensaje'=> 'Datos Grabados.') );
        break;
        case "aprobar_abono":
            $id     = (isset($_POST['idAbono']))?filter_var($_POST['idAbono'],FILTER_SANITIZE_NUMBER_INT):0;
            $fecha  = date('Y-m-d H:i:i');
            $sql = "UPDATE wp_es_abonos SET fecha='$fecha',estado='B' WHERE id=$id";
            $con->query($sql);
            echo json_encode( array("response"=>'success','mensaje'=> 'Abono Aprobado.') );
        break;
        case "notificar_total_abonos":
            $id     = (isset($_POST['agenda']))?filter_var($_POST['agenda'],FILTER_SANITIZE_NUMBER_INT):0;
            $sql = "SELECT s.id as idAgenda,startdate,
            DAY(startdate) as dia,MONTH(startdate) as mes,YEAR(startdate) as anio,
            HOUR(startdate) as hora,MINUTE(startdate) as minuto,SECOND(startdate) as segundos,
            cant,p.nombre as nombrePlan,c.nombre as nombreCliente,c.apellido,c.telefono,
            c.direccion,c.email,documento,b.nombre as nombreBote,o.totalorden,IF(p.franjahoraria=1,'Día','Noche') AS horario,o.codigoreserva,o.id as idOrden,s.descripcion
            FROM wp_es_solution_shedule s
            INNER JOIN wp_es_planes p ON(p.id=s.idplan) 
            INNER JOIN wp_es_clientes c ON(s.cliente=c.id)
            INNER JOIN wp_es_botes b ON(idbote=b.id)
            INNER JOIN wp_es_orden o ON(o.reserva=s.id)
            WHERE s.estado = 'A' AND s.id=$id";
            $result = $con->query($sql);
            $abono      = 0;
            $saldo      = '';
            $email      = '';
            $documento  = '';
            $plan       = '';
            $bote       = '';
            $npersonas  = '';
            $fecha      = '';
            $nombre     = '';
            $total      = '';
            $saldo      = '';
            if($result->num_rows>=1){
                while($row = $result->fetch_assoc()){
                    $abono      = getTotalAbonado($con,$row['idAgenda']);
                    $saldo      = $row['totalorden'] - $abono;
                    $email      = $row['email'];
                    $documento  = $row['documento'];
                    $plan       = $row['nombrePlan'];
                    $bote       = $row['nombreBote'];
                    $npersonas  = $row['cant'];
                    $fecha      = $row['dia'].'/'.$row['mes'].'/'.$row['anio'];
                    $nombre     = $row['nombreCliente'];
                    $apellido   = $row['apellido'];
                    $codreserva = $row['codigoreserva'];
                    $idOrden    = $row['idOrden'];
                    $desc       = $row['descripcion'];
                    $total      = '$'.number_format($row['totalorden'],0,'.',',');
                    $saldo      = '$'.number_format($saldo,0,'.',',');
                    $abono      = '$'.number_format($abono,0,'.',',');
                }
            }
            $sql = "SELECT nombre,cant,a.precio FROM wp_es_ordendetalle d INNER JOIN wp_es_adicionales a ON(a.id=d.iditem) WHERE idorden=$idOrden";
            $result = $con->query($sql);
            $catering = '';
            if($result->num_rows>=1){
                while($row = $result->fetch_assoc()){
                    //$catering = $catering.''.$row['nombre'].' x'.$row['cant'].' '.$row['precio']." \r\n";
                    $catering = $catering. "<tr><td colspan='2'>".$row['nombre'].' x'.$row['cant'].' '.$row['precio']."</td></tr>";
                }
            }


            $para = $email;
            $mensaje    = '';
            $from       = 'reservasonline@botesdelabahia.com';
            $header     = 'From: ' . $from . " \r\n";
            $header    .= "X-Mailer: PHP/" . phpversion() . " \r\n";
            $header    .= "Mime-Version: 1.0 \r\n";
            $header    .= "Content-type: text/html; charset=iso-8859-1 \r\n";
            $header    .= "Bcc: gerencia@botesdelabahia.com,reservas@botesdelabahia.com \r\n";


            $mensaje="
            <img src='https://botesdelabahia.com/wp-content/uploads/2019/05/Logo4-Horizontal222px.png' alt='img' width='222' height='59'><br/>
            <table>
                <tr>
                    <td>Nombre</td>
                    <td>$nombre</td>
                </tr>
                <tr>
                    <td>Apellido</td>
                    <td>$apellido</td>
                </tr>
                <tr>
                    <td>Documento</td>
                    <td>$documento</td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td>$email</td>
                </tr>
                <tr>
                    <td>Bote</td>
                    <td>$bote</td>
                </tr>
                <tr>
                    <td>Plan</td>
                    <td>$plan</td>
                </tr>
                <tr>
                    <td>Descripción</td>
                    <td>$desc</td>
                </tr>
                <tr>
                    <td>Nro. Personas</td>
                    <td>$npersonas</td>
                </tr>
                <tr>
                    <td>Fecha de salida</td>
                    <td>$fecha</td>
                </tr>
                <tr>
                    <td>Total</td>
                    <td>$total</td>
                </tr>
                <tr>
                    <td>Saldo</td>
                    <td>$saldo</td>
                </tr>
                <tr>
                    <td>Abono</td>
                    <td>$abono</td>
                </tr>
                <tr>
                    <td>Enviado el</td>
                    <td>".date('d/m/Y H:i:s4', time())."</td>
                </tr>
                <tr>
                    <td>Codigo Reserva</td>
                    <td>$codreserva</td>
                </tr>
                $catering
            </table>";
            $asunto     = 'CONFIRMACIÓN DE ABONOS';
            mail($para, $asunto, utf8_decode($mensaje), $header);
            echo json_encode( array("response"=>'success','mensaje'=> 'Mensaje Enviado.') );
        break;
        case "eliminar_usuario":
            $id = (isset($_POST['id']))?filter_var($_POST['id'],FILTER_SANITIZE_NUMBER_INT):0;
            if($id>0){
                $sql = "DELETE FROM wp_es_usuarios WHERE ID=$id";
                $con->query($sql);
                echo json_encode( array("response"=>'success','mensaje'=> 'Usuario Eliminado.') );
            }else{
                echo json_encode( array("response"=>'fail','mensaje'=> 'No existe es usuario.' ) );
            }
        break;
        case "validar_bote":
            $fecha  = date('Y-m-d',strtotime($_POST['fecha'])  ) ;
            $plan   = $_POST['plan'];
            $bote   = $_POST['bote'];
            if(isBoteDisponible($con,$fecha,$bote,$plan)){
                echo json_encode( array("response"=>'success','mensaje'=> 'ok' ) );
            }else{
                $sql = "SELECT b.nombre FROM wp_es_solution_shedule s INNER JOIN wp_es_botes b ON(idbote=b.id) WHERE date(startdate)='".$fecha."' AND s.estado='A'";
                $result = $con->query($sql);
                $body = '';
                if($result->num_rows>=1){
                    while($row = $result->fetch_assoc()){
                        $body = $body."\n".$row['nombre'];
                    }
                }
                echo json_encode( array("response"=>'fail','mensaje'=> "Los siguientes botes NO estan disponibles para esta fecha:".$body ) );
            }
        break;
    }
}else{
    
    if(isset($_POST['action'])){
        switch($_POST['action']){
            case 'detalleplanfront':
                $plan = (isset($_POST['plan']))?filter_var($_POST['plan'],FILTER_SANITIZE_NUMBER_INT):0;
                $_SESSION['plan'] = $plan;
                $html = '';
                echo json_encode( array("response"=>'success','mensaje'=> 'Informaci&oacute;n cargada con exito. ','html'=>$html ) );
            break;
            case 'resumen_frontend':
                $catering = '';
                $valcat = 0;
                if( isset($_SESSION['catering']) ){
                    foreach($_SESSION['catering'] as $item){
                        $nombre = $item['nombre'].' X'.$item['cant'];
                        $catering = $catering. '
                        <div class="clearfix">
                            <div>'.$nombre.'</div>
                        </div>';
                        $valcat = $valcat + ($item['cant']*$item['precio']);
                    }
                }
                $base = $_SESSION['precio'] + $valcat;
                $desc = 0;
                $totaldec = 0;
                if(isset($_SESSION['desc'])){
                    $desc =  ($_SESSION['precio']*$_SESSION['desc'])/100;
                    $totaldec = $base - $desc;
                }
                
                $html = '
                <div>
                    <h3>RESUMEN</h3>
                </div>
                <div class="eresrowresum clearfix">
                    <div>Fecha de partida</div>
                    <div>'.$_SESSION['fecha'].'</div>
                </div>
                <div class="eresrowresum clearfix">
                    <div>Pasajeros</div>
                    <div>'.$_SESSION['personas'].'</div>
                </div>
                <div class="eresrowresum clearfix">
                    <div>Bote</div>
                    <div>'.$_SESSION['botenombre'].'</div>
                </div>
                '.$catering.'
                <div>
                    <h3><span>$'.number_format($base,0,".",",").'</span></h3>
                </div>
                ';
                $totaldec = $base - $desc;
                if($desc>0){
                    $html=$html.'
                    <div>
                        <h3>Descuento: <span>$'.number_format($desc,0,".",",").'</span></h3>
                    </div>
                    <div>
                        <h3>Total: <span>$'.number_format($totaldec,0,".",",").'</span></h3>
                    </div>';    
                }
                //$_SESSION['precio']
                echo json_encode( array("response"=>'success','mensaje'=> 'Informaci&oacute;n cargada con exito. ','html'=>$html ) );
            break;
            case 'add_p_cat':
                $val        = $_POST['val'];
                $nombre     = $_POST['nombre'];
                $id         = $_POST['id'];
                
                if(isset($_POST['id'])){
                    if($_POST['val']==0 && isset($_SESSION['catering'][$_POST['id']]) ){
                        unset($_SESSION['catering'][$_POST['id']]);
                    }else{
                        $_SESSION['catering'][$_POST['id']]=array('nombre'=>$_POST['nombre'],'precio'=>$_POST['precio'],'cant'=>$_POST['val'],'id'=>$_POST['id']);
                    }
                }
                echo json_encode( array("response"=>'success','mensaje'=> 'Exito') );
            break;
            case 'cambiarfecha':
                $html='';
                if(isset($_POST['fecha']) && !empty($_POST['fecha'])){
                    $fecha  = (isset($_POST['fecha']))?filter_var($_POST['fecha'],FILTER_SANITIZE_STRING):'';
                    $ffecha = (isset($_POST['selectDate']))?filter_var($_POST['selectDate'],FILTER_SANITIZE_STRING):'';
                    $pasa   = (isset($_POST['pasajeros']))?filter_var($_POST['pasajeros'],FILTER_SANITIZE_NUMBER_INT):0;
                    $plan   = (isset($_POST['plan']))?filter_var($_POST['plan'],FILTER_SANITIZE_NUMBER_INT):0;
                    $_SESSION['fecha'] = $fecha;
                    $array = obtenerBotesDisponibles($con,$ffecha);
                    $sql = "SELECT b.id,nombre,pag.precio FROM wp_es_botes b INNER JOIN wp_es_valores_planes_botes pag ON(pag.idbote=b.id AND idplan=$plan) WHERE b.estado='A' AND pasajeros>=$pasa";
                    $rsbotes = $con->query($sql);
                    $swfirst = false;
                    foreach($rsbotes as $item){
                        if (in_array($item['id'], $array)) {
                            if(!$swfirst){
                                $_SESSION['botenombre'] = $item['nombre'];
                                $_SESSION['boteid'] = $item['id'];
                                $_SESSION['precio'] = $item['precio'];
                                $swfirst=true;
                            }
                            $html =$html. '<option value="'.$item['id'].'">'.$item['nombre'].'</option>';
                        }
                    }
                }
                echo json_encode( array("response"=>'success','mensaje'=> 'Exito','html'=>$html) );
            break;
            case 'cambiar_personas_front':
                $ffecha = (isset($_POST['selectDate']))?filter_var($_POST['selectDate'],FILTER_SANITIZE_STRING):'';
                $t= explode("/",$ffecha);
                $fecha = $t[2].'-'.$t[0].'-'.$t[1];
                $plan   = (isset($_POST['plan']))?filter_var($_POST['plan'],FILTER_SANITIZE_NUMBER_INT):0;
                $pasa   = (isset($_POST['personas']))?filter_var($_POST['personas'],FILTER_SANITIZE_NUMBER_INT):0;
                
                $array = obtenerBotesDisponibles($con,$fecha);
                $sql = "SELECT b.id,nombre,pag.precio FROM wp_es_botes b INNER JOIN wp_es_valores_planes_botes pag ON(pag.idbote=b.id AND idplan=$plan) WHERE b.estado='A' AND pasajeros>=$pasa";
                $rsbotes = $con->query($sql);
                $swfirst = false;
                $html = '';
                foreach($rsbotes as $item){
                    if (in_array($item['id'], $array)) {
                        if(!$swfirst){
                            $_SESSION['botenombre'] = $item['nombre'];
                            $_SESSION['boteid'] = $item['id'];
                            $_SESSION['precio'] = $item['precio'];
                            $swfirst=true;
                        }
                        $html =$html. '<option value="'.$item['id'].'">'.$item['nombre'].'</option>';
                    }
                }
                header("Content-type: application/json");
                echo json_encode( array("response"=>'success','mensaje'=> 'Exito','html'=>$html) );
            break;
            case "cambiar_bote_front":
                $plan   = (isset($_POST['plan']))?filter_var($_POST['plan'],FILTER_SANITIZE_NUMBER_INT):0;
                $bote   = (isset($_POST['bote']))?filter_var($_POST['bote'],FILTER_SANITIZE_NUMBER_INT):0;
                $sql = "SELECT b.id,nombre,pag.precio FROM wp_es_botes b INNER JOIN wp_es_valores_planes_botes pag ON(pag.idbote=b.id AND idplan=$plan) WHERE b.estado='A' AND b.id=$bote";
                $rsbotes = $con->query($sql);
                $swfirst = false;
                foreach($rsbotes as $item){
                    $_SESSION['botenombre'] = $item['nombre'];
                    $_SESSION['boteid'] = $item['id'];
                    $_SESSION['precio'] = $item['precio'];
                }
                echo json_encode( array("response"=>'success','mensaje'=> 'Exito') );
            break;
            case "login":
                $usuario    = (isset($_POST['usuario']))?filter_var($_POST['usuario'],FILTER_SANITIZE_STRING):'';
                $clave      = (isset($_POST['clave']))?filter_var($_POST['clave'],FILTER_SANITIZE_STRING):'';
                $plan       = (isset($_POST['plan']))?filter_var($_POST['plan'],FILTER_SANITIZE_NUMBER_INT):'';
                $bote       = (isset($_POST['bote']))?filter_var($_POST['bote'],FILTER_SANITIZE_NUMBER_INT):'';
                $fecha      = (isset($_POST['fecha']))?filter_var($_POST['fecha'],FILTER_SANITIZE_STRING):'';
                $pasajeros  = (isset($_POST['pasajeros']))?filter_var($_POST['pasajeros'],FILTER_SANITIZE_NUMBER_INT):'';
                $asesor     = 0;
                $sql        = "SELECT id FROM wp_es_usuarios where usuario='".$usuario."' AND clave=MD5('".$clave."') AND estado='A'";
                $result     = $con->query($sql);
                if($result->num_rows>=1){
                    $row = $result->fetch_assoc();
                    if(isBoteDisponible($con,$fecha,$bote,$plan)){
                        $_SESSION['idCliente']     = $row['id'];
                        if(isset($_SESSION['desc'])){
                            $desc =  ($_SESSION['precio']*$_SESSION['desc'])/100;
                            $totaldec = $_SESSION['precio'] - $desc;
                            $_SESSION['precio'] = $totaldec;
                        }
                        
                        $idAgenda = guardarAgenda($con,$fecha,$pasajeros,$plan,$bote,$_SESSION['idCliente'],$asesor);
                        if($idAgenda){
                            $_SESSION['reserva'] = (isset($_SESSION['precio']))?$_SESSION['precio']:0;
                            if($_SESSION['reserva']>0){
                                $irOrder = generarFacturacion($con,$bote,$plan,$fecha,$idAgenda);
                                $total = (isset($_SESSION['totalventa']))?$_SESSION['totalventa']:0;
                                if(!empty($irOrder)){
                                    echo json_encode( array("response"=>'success','mensaje'=> 'Sesion Iniciada','idOrden'=>$irOrder,'total'=>'$'.number_format($total,0,".",",") ) );
                                    unset($_SESSION['reserva']);
                                }else{
                                    echo json_encode( array("response"=>'fail','mensaje'=> 'No se pudo crear orden.' ) );
                                }
                            }else{
                                echo json_encode( array("response"=>'fail','mensaje'=> 'No se pudo obtener total del servicio.' ) );
                            }
                            
                        }else{
                            echo json_encode( array("response"=>'fail','mensaje'=> 'No se pudo agendar la reserva.' ) );
                        }
                    }else{
                        echo json_encode( array("response"=>'fail','mensaje'=> 'El bote seleccionado no esta disponible en esa fecha.' ) );
                    }
                }else{
                    echo json_encode( array("response"=>'fail','mensaje'=> 'Usuario o clave invalidos' ) );
                }
            break;
            case "register":
                $nombre     = (isset($_POST['nombre']))? filter_var($_POST['nombre'],FILTER_SANITIZE_STRING):'';
                $apellido   = (isset($_POST['apellido']))?filter_var($_POST['apellido'],FILTER_SANITIZE_STRING):'';
                $telefono   = (isset($_POST['telefono']))?filter_var($_POST['telefono'],FILTER_SANITIZE_STRING):'';
                $email      = (isset($_POST['email']))?filter_var($_POST['email'],FILTER_SANITIZE_EMAIL):'';
                $documento  = (isset($_POST['documento']))?filter_var($_POST['documento'],FILTER_SANITIZE_STRING):'';
                $direccion  = (isset($_POST['direccion']))?filter_var($_POST['direccion'],FILTER_SANITIZE_STRING):'';
                $usuario    = (isset($_POST['usuario']))?filter_var($_POST['usuario'],FILTER_SANITIZE_STRING):'';
                $clave      = (isset($_POST['clave']))?filter_var($_POST['clave'],FILTER_SANITIZE_STRING):'';
                $desc       = (isset($_POST['desc']))?filter_var($_POST['desc'],FILTER_SANITIZE_STRING):'';
                if(!empty($nombre) && !empty($apellido) && !empty($telefono) && !empty($email) && !empty($documento) && !empty($direccion) && !empty($usuario) && !empty($clave)){
                    try{
                        if(isset($_SESSION['desc'])){
                            $desc =  ($_SESSION['precio']*$_SESSION['desc'])/100;
                            $totaldec = $_SESSION['precio'] - $desc;
                            $_SESSION['precio'] = $totaldec;
                        }
                        $sql = "INSERT INTO wp_es_clientes(nombre,apellido,telefono,direccion,email,clave,asesor,documento) 
                        VALUE('$nombre','$apellido','$telefono','$direccion','$email',MD5('$clave'),'$usuario','$documento')";
                        $con->query($sql);
                        $_SESSION['idCliente'] = $con->insert_id;
                        $tmp = explode("/",$_SESSION['fecha']);
                        $fecha = $tmp[2].'-'.$tmp[1].'-'.$tmp[0];
                        $personas = $_SESSION['personas'];
                        $bote = $_SESSION['boteid'];
                        $cliente = $_SESSION['idCliente'];
                        $asesor = 0;
                        $plan = $_SESSION['plan'];
                        $_SESSION['reserva'] = $_SESSION['precio'];
                        $idAgenda = guardarAgenda($con,$fecha,$personas,$plan,$bote,$cliente,$asesor,$desc);
                        $idOrden = generarFacturacion($con,$bote,$plan,$fecha,$idAgenda);
                        $total = (isset($_SESSION['totalventa']))?$_SESSION['totalventa']:0;
                        echo json_encode( array("response"=>'success','mensaje'=> 'Usted se ha registrado con exito','idOrden'=>$irOrder,'total'=>'$'.number_format($total,0,".",",")   ) );
                    }catch(Exception $err){
                        echo json_encode( array("response"=>'fail','mensaje'=> 'Usted se ha registrado con exito' ) );
                    }
                }else{
                    echo json_encode( array("response"=>'fail','mensaje'=> 'Llene todos los campos del formulario' ) );
                }
            break;
            case "validar_bote":
                $fecha  = date('Y-m-d',strtotime($_POST['fecha'])  ) ;
                $plan   = $_POST['plan'];
                $bote   = $_POST['bote'];
                if(isBoteDisponible($con,$fecha,$bote,$plan)){
                    echo json_encode( array("response"=>'success','mensaje'=> 'ok' ) );
                }else{
                    $sql = "SELECT b.nombre FROM wp_es_solution_shedule s INNER JOIN wp_es_botes b ON(idbote=b.id) WHERE date(startdate)='".$fecha."' AND s.estado='A'";
                    $result = $con->query($sql);
                    $body = '';
                    if($result->num_rows>=1){
                        while($row = $result->fetch_assoc()){
                            $body = $body."\n".$row['nombre'];
                        }
                    }
                    echo json_encode( array("response"=>'fail','mensaje'=> "Los siguientes botes NO estan disponibles para esta fecha:".$body ) );
                }
                
            break;
        }
    }
    
}
function obtenerBotesDisponibles($con,$fecha){
    $sql = "SELECT b.id FROM wp_es_botes b INNER JOIN wp_es_solution_shedule s ON(b.id=s.idbote AND DATE(s.startdate) = DATE('$fecha') AND s.estado='A')";
    $rsagenda = $con->query($sql);
    $arrayBotesNoDisponible = array();
    if($rsagenda->num_rows>=1){
        while($item = $rsagenda->fetch_assoc()){
            $arrayBotesNoDisponible[] = intval($item['id']);
        }
    }
    $sql = "SELECT b.id FROM wp_es_botes b WHERE b.estado='A'";
    $rsbotes = $con->query($sql);
    $arrayBotes = array();
    if($rsbotes->num_rows>=1){
        while($item = $rsbotes->fetch_assoc()){
            $idBote     = intval($item['id']);
            if(!in_array($idBote,$arrayBotesNoDisponible)){
                $arrayBotes[] = $idBote;
            }
        }
    }
    return $arrayBotes;
}
function generarFacturacion($con,$bote,$plan,$fecha,$idAgenda){
    $total_base = (isset($_SESSION['reserva']))?$_SESSION['reserva']:0;
    $catering = '';
    $valcat = 0;
    $idOrder = 0;
    if(isset($_SESSION['catering'])){
        foreach($_SESSION['catering'] as $item){
            $valcat = $valcat + ($item['cant']*$item['precio']);
        }
    }
    $total = $total_base + $valcat;
    $_SESSION['totalventa'] = $total;
    $codigo = generateRandomString();
    $sql        = "INSERT INTO wp_es_orden(totalorden,descuento,idbote,idplan,fecha,estado,reserva,codigoreserva) value($total,0,$bote,$plan,'$fecha','A',$idAgenda,'$codigo')";
    if ($con->query($sql) === true) {
        $last_id = $con->insert_id;
        if(isset($_SESSION['catering'])){
            foreach($_SESSION['catering'] as $item){
                $id = $item['id'];
                $cant = $item['cant'];
                if($last_id>0){
                    $sql = "INSERT INTO wp_es_ordendetalle(idorden,iditem,estado,cant) VALUE($last_id,$id,'A',$cant)";
                    $con->query($sql);
                }
            }
        }
    }
    return $codigo;
}
function isBoteDisponible($con,$fecha,$bote,$plan){
    $sql = "SELECT b.id FROM wp_es_botes b INNER JOIN wp_es_solution_shedule s ON(b.id=s.idbote AND DATE(s.startdate) = DATE('$fecha') AND s.estado='A') 
    INNER JOIN wp_es_planes p ON(s.idplan=p.id AND p.franjahoraria=(SELECT franjahoraria FROM wp_es_planes WHERE id=$plan)) 
    WHERE b.id=$bote";
    $rsagenda = $con->query($sql);
    if($rsagenda->num_rows>=1){
        return false;
    }else{
        return true;
    }
}
function guardarAgenda($con,$fecha,$personas,$plan,$bote,$cliente,$asesor,$desc=''){
    try{
        $sql = "INSERT INTO wp_es_solution_shedule(startdate,cant,idplan,idbote,estado,cliente,asesor,descripcion) VALUE('$fecha',$personas,$plan,$bote,'A',$cliente,$asesor,'$desc')";
        $con->query($sql);
        return $con->insert_id;
    }catch(Exception $err){
        return false;
    }
}
function getCliente($con,$documento){
    $sql = "SELECT id FROM wp_es_clientes WHERE documento='$documento'";
    $result = $con->query($sql);
    if($result->num_rows>=1){
        $row = $result->fetch_assoc();
        return $row['id'];
    }else{
        return 0;
    }
}
function getEstadoAbono($estado){
    switch($estado){
        case 'A':
            return 'Abonado';
        break;
        case 'B':
            return 'Aprobado';
        break;
        case 'I':
            return 'Cancelado';
        break;
    }
}
function getTotalAbonado($con,$reserva){
    $sql = "SELECT SUM(a.abono) AS abono FROM wp_es_abonos a INNER JOIN wp_es_orden o ON(a.idorden=o.id AND o.reserva=$reserva)";
    $result = $con->query($sql);
    if($result->num_rows>=1){
        $row = $result->fetch_assoc();
        return $row['abono'];
    }else{
        return 0;
    }
}
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
} 
$con->close();
?>