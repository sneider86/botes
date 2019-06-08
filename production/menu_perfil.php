<li class="">
    <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
    <img src="images/img.jpg?v<?php echo date('his');?>" alt=""><?php echo $_SESSION['nombre']; ?>
    <span class=" fa fa-angle-down"></span>
    </a>
    <ul class="dropdown-menu dropdown-usermenu pull-right">
    <li><a href="javascript:;"> Perfil</a></li>
    <li><a href="logout.php<?php echo '?v='.date('his'); ?>"><i class="fa fa-sign-out pull-right"></i> Salir</a></li>
    </ul>
</li>