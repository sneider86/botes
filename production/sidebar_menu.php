<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
        <h3>General</h3>
        <ul class="nav side-menu">
            <li><a href="index.php<?php echo '?v='.date('his'); ?>"><i class="fa fa-home"></i> Inicio</a></li>
            <?php 
                if(isset($_SESSION['permisos']) && isset($_SESSION['permisos'][1]) && $_SESSION['permisos'][1]==1){
                    echo '<li><a><i class="fa fa-edit"></i> Reserva <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">';
                    if(isset($_SESSION['permisos'][2]) && $_SESSION['permisos'][2] == 1){
                        echo '<li><a href="calendar.php?v='.date('his').'">Ver Reservas</a></li>';
                    }
                    if(isset($_SESSION['permisos'][3]) && $_SESSION['permisos'][3] == 1){
                        echo '<li><a href="crearreserva.php?v='.date('his').'">Crear Reservas</a></li>';
                    }
                    if(isset($_SESSION['permisos'][23]) && $_SESSION['permisos'][23] == 1){
                        echo '<li><a href="crearreservacliente.php?v='.date('his').'">Crear Reservas & Cliente</a></li>';
                    }
                    echo '</ul>
                    </li>';
                }
                if(isset($_SESSION['permisos']) && isset($_SESSION['permisos'][4]) &&  $_SESSION['permisos'][4]==1){
                    echo '<li><a><i class="fa fa-edit"></i> Clientes <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">';
                    if(isset($_SESSION['permisos'][5]) && $_SESSION['permisos'][5] == 1){
                        echo '<li><a href="crear_cliente.php?v='.date('his').'">Crear Cliente</a></li>';
                    }
                    if(isset($_SESSION['permisos'][6]) && $_SESSION['permisos'][6] == 1){
                        echo '<li><a href="ver_cliente.php?v='.date('his').'">Ver Clientes</a></li>';
                    }
                    echo '</ul>
                    </li>';
                }
                if(isset($_SESSION['permisos']) && isset($_SESSION['permisos'][7]) && $_SESSION['permisos'][7]==1){
                    echo '<li><a><i class="fa fa-edit"></i> Planes <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">';
                    if(isset($_SESSION['permisos'][8]) && $_SESSION['permisos'][8] == 1){
                        echo '<li><a href="crearplanes.php?v='.date('his').'">Crear Planes</a></li>';
                    }
                    if(isset($_SESSION['permisos'][9]) && $_SESSION['permisos'][9] == 1){
                        echo '<li><a href="verplanes.php?v='.date('his').'">Ver Planes</a></li>';
                    }
                    echo '</ul>
                    </li>';
                }
                if(isset($_SESSION['permisos']) && isset($_SESSION['permisos'][10]) &&  $_SESSION['permisos'][10]==1){
                    echo '<li><a><i class="fa fa-edit"></i> Administrar <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">';
                    if(isset($_SESSION['permisos'][11]) && $_SESSION['permisos'][11] == 1){
                        echo '<li><a href="crearusuarios.php?v='.date('his').'">Crear Usuarios</a></li>';
                    }
                    if(isset($_SESSION['permisos'][12]) && $_SESSION['permisos'][12] == 1){
                        echo '<li><a href="editarusuarios.php?v='.date('his').'">Editar Usuarios</a></li>';
                    }
                    if(isset($_SESSION['permisos'][13]) && $_SESSION['permisos'][13] == 1){
                        echo '<li><a href="perfiles.php?v='.date('his').'">Permisos</a></li>';
                    }
                    if(isset($_SESSION['permisos'][14]) && $_SESSION['permisos'][14] == 1){
                        echo '<li><a href="crearperfil.php?v='.date('his').'">Crear Perfil</a></li>';
                    }
                    echo '</ul>
                    </li>';
                }
                if(isset($_SESSION['permisos']) && isset($_SESSION['permisos'][15]) && $_SESSION['permisos'][15]==1){
                    echo '<li><a><i class="fa fa-edit"></i> Botes <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">';
                    if(isset($_SESSION['permisos'][16]) && $_SESSION['permisos'][16] == 1){
                        echo '<li><a href="crearbote.php?v='.date('his').'">Crear Bote</a></li>';
                    }
                    if(isset($_SESSION['permisos'][17]) && $_SESSION['permisos'][17] == 1){
                        echo '<li><a href="verbotes.php?v='.date('his').'">Ver Botes</a></li>';
                    }
                    if(isset($_SESSION['permisos'][18]) && $_SESSION['permisos'][18] == 1){
                        echo '<li><a href="crearpreciosbotes.php?v='.date('his').'">Precios</a></li>';
                    }
                    if(isset($_SESSION['permisos'][19]) && $_SESSION['permisos'][19] == 1){
                        echo '<li><a href="verpreciosbotes.php?v='.date('his').'">Ver Precios</a></li>';
                    }
                    echo '</ul>
                    </li>';
                }
                if(isset($_SESSION['permisos']) && isset($_SESSION['permisos'][20]) && $_SESSION['permisos'][20]==1){
                    echo '<li><a><i class="fa fa-edit"></i> Catering <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">';
                    if(isset($_SESSION['permisos'][21]) && $_SESSION['permisos'][21] == 1){
                        echo '<li><a href="crearcatering.php?v='.date('his').'">Crear Catering</a></li>';
                    }
                    if(isset($_SESSION['permisos'][22]) && $_SESSION['permisos'][22] == 1){
                        echo '<li><a href="vercatering.php?v='.date('his').'">Ver Catering</a></li>';
                    }
                    echo '</ul>
                    </li>';
                }
            ?>
        </ul>
    </div>
</div>