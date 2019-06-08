<?php
session_start();
if(!isset($_SESSION['idPerfil'])){
    header('Location:../index.html?v='.date('his'));
}
?>