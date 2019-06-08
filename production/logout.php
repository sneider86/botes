<?php
session_start();
session_destroy();
header('Location:../index.html?v='.date('his'));
?>