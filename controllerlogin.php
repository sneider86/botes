<?php
session_start();
require_once 'config/configbd.php';
$con = new mysqli($bd['host'],$bd['user'],$bd['pass'],$bd['data']);

if ($con->connect_error) {
    header('Location: index.html');
}else{
    $username = '';
    $pass = '';
    if(isset($_POST['username']) && !empty($_POST['username'])){
        $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    }
    if(isset($_POST['pass']) && !empty($_POST['pass'])){
        $pass = filter_var($_POST['pass'], FILTER_SANITIZE_STRING);
    }
    $sql = "SELECT u.id as idUser,u.nombre,p.id as idPerfil 
        FROM wp_es_usuarios u 
        INNER JOIN wp_es_perfiles p ON(u.perfil=p.id AND p.estado='A')
        WHERE usuario='".$username."' AND clave=MD5('".$pass."') AND u.estado='A'";
    $result = $con->query($sql);
    if($result->num_rows>=1){
        $row = $result->fetch_assoc();
        $_SESSION['nombre']     = $row['nombre'];
        $_SESSION['idUser']     = $row['idUser'];
        $_SESSION['idPerfil']   = $row['idPerfil'];
        $_SESSION['url_base']   = $urlbas['url'].'administrar';
        $result->close();
        $sql = 'SELECT permiso,modulo FROM wp_es_permisos WHERE perfil='.$_SESSION['idPerfil'];
        $result = $con->query($sql);
        $permisos = array();
        while($item = $result->fetch_assoc()){
            $permisos[$item['modulo']]=$item['permiso'];
        }
        $_SESSION['permisos'] = $permisos;

        $con->close();
        header('Location: '.$urlbas['url'].'administrar/production?v='.date('his'));
    }else{
        $result->close();
        $con->close();
        session_destroy();
        header('Location: index.php');
    }
} 

?>