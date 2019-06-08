<?php 
require_once 'session.php';
if(!isset($_SESSION['permisos'][13]) || $_SESSION['permisos'][13]!=1){
  header('Location:index.php?v='.date('his'));
}
require_once '../config/configbd.php';
$con        = new mysqli($bd['host'],$bd['user'],$bd['pass'],$bd['data']);
$con->set_charset("utf8");
$sql        = "SELECT id,nombre,estado FROM wp_es_perfiles;";
$result     = $con->query($sql);

$array[] = array('id'=>1,'nombre'=>'Reserva' );
$array[] = array('id'=>2,'nombre'=>'Ver Reserva' );
$array[] = array('id'=>3,'nombre'=>'Crear Reserva' );
$array[] = array('id'=>4,'nombre'=>'Clientes' );
$array[] = array('id'=>5,'nombre'=>'Crear Cliente' );
$array[] = array('id'=>6,'nombre'=>'Ver Cliente' );
$array[] = array('id'=>7,'nombre'=>'Planes' );
$array[] = array('id'=>8,'nombre'=>'Crear Planes' );
$array[] = array('id'=>9,'nombre'=>'Ver Planes' );
$array[] = array('id'=>10,'nombre'=>'Administrar' );
$array[] = array('id'=>11,'nombre'=>'Crear Usuario' );
$array[] = array('id'=>12,'nombre'=>'Editar Usuario' );
$array[] = array('id'=>13,'nombre'=>'Ver Perfiles' );
$array[] = array('id'=>14,'nombre'=>'Crear Perfil' );
$array[] = array('id'=>15,'nombre'=>'Botes' );
$array[] = array('id'=>16,'nombre'=>'Crear Botes' );
$array[] = array('id'=>17,'nombre'=>'Ver Botes' );
$array[] = array('id'=>18,'nombre'=>'Crear Precios Botes' );
$array[] = array('id'=>19,'nombre'=>'Ver Precios Botes' );
$array[] = array('id'=>20,'nombre'=>'Catering' );
$array[] = array('id'=>21,'nombre'=>'Crear Catering' );
$array[] = array('id'=>22,'nombre'=>'Ver Catering' );
$array[] = array('id'=>23,'nombre'=>'Crear Reserva & Cliente' );
$max = count($array);
$html = '';
foreach($array as $item){

  $html=$html.'<div class="form-group">
  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="'.$item['id'].'">'.$item['nombre'].' <span class="required">*</span></label>
  <div class="col-md-6 col-sm-6 col-xs-12">
      <select id="'.$item['id'].'" name="'.$item['id'].'" class="form-control">
          <option value="1">Activo</option>
          <option value="0">Inactivo</option>
      </select>
  </div>
</div>';
}
        
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" co+6+9+ntent="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	  
    <?php include_once 'titulo_admin.php'; ?>

    <!-- Bootstrap -->
    <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="../vendors/iCheck/skins/flat/green.css" rel="stylesheet">
    <!-- bootstrap-wysiwyg -->
    <link href="../vendors/google-code-prettify/bin/prettify.min.css" rel="stylesheet">
    <!-- Select2 -->
    <link href="../vendors/select2/dist/css/select2.min.css" rel="stylesheet">
    <!-- Switchery -->
    <link href="../vendors/switchery/dist/switchery.min.css" rel="stylesheet">
    <!-- starrr -->
    <link href="../vendors/starrr/dist/starrr.css" rel="stylesheet">
    <!-- bootstrap-daterangepicker -->
    <link href="../vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

    <!-- PNotify -->
    <link href="../vendors/pnotify/dist/pnotify.css" rel="stylesheet">
    <link href="../vendors/pnotify/dist/pnotify.buttons.css" rel="stylesheet">
    <link href="../vendors/pnotify/dist/pnotify.nonblock.css" rel="stylesheet">

     <!-- Datatables -->
     <link href="../vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="../build/css/custom.min.css" rel="stylesheet">

  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <?php
              include_once 'titulo_menu.php';
            ?>
            <div class="clearfix"></div>
            <!-- menu profile quick info -->
            <?php 
              include_once 'perfil.php';
            ?>
            <!-- /menu profile quick info -->
            <br />
            <!-- sidebar menu -->
            <?php require_once 'sidebar_menu.php'; ?>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <?php include_once 'menu_footer.php'; ?>
            <!-- /menu footer buttons -->
          </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>

              <ul class="nav navbar-nav navbar-right">
              <?php include_once 'menu_perfil.php'; ?>

                <li role="presentation" class="dropdown">
                  <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-envelope-o"></i>
                    <span class="badge bg-green">6</span>
                  </a>
                </li>
              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Usuario</h3>
              </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Ver Usuario </h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                    <div class="col-md-12 col-sm-6 col-xs-12">
                    <table id="datatable" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Estado</th>
                            <th>Acci&oacute;n</th>
                            <th>Permisos</th>
                        </tr>
                      </thead>
                      <tbody>
                          <?php
                            if($result->num_rows>=1){
                                while($perfil = $result->fetch_assoc()){
                                    $sql      = "SELECT modulo,permiso FROM wp_es_permisos WHERE perfil=".$perfil['id'];
                                    $rsper    = $con->query($sql);
                                    $data = array();
                                    while($items = $rsper->fetch_assoc()){
                                      $data[] = $items;
                                    }
                                    echo '<tr>';
                                    echo '<td>'.$perfil['nombre'].'</td>';
                                    echo '<td>'.$perfil['estado'].'</td>';
                                    echo '<td><button type="button" data=\''.json_encode($perfil).'\'" class="btn btn-primary btn_modal_edit_form" data-toggle="modal" data-target=".medit">Editar</button></td>';
                                    echo '<td><button type="button" data=\''.json_encode($perfil).'\'" data_permiso=\''.json_encode($data).'\'" class="btn btn-primary btn_modal_edit_form_permiso" data-toggle="modal" data-target=".mperfil">Permisos</button></td>';
                                    echo '</tr>';
                                }
                            }
                          ?>
                      </tbody>
                      
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <form id="demo-form2" action="../controllers/contoller.php" method="POST" data-parsley-validate class="form-horizontal form-label-left">
            <input type="hidden" name="action" value="grabar_perfil" />
            <div class="modal fade bs-example-modal-lg medit" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel">Perfil</h4>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="txtidperfil" name="idperfil">
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nombre">Nombre <span class="required">*</span></label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="nombre" name="nombre" required="required" class="form-control col-md-7 col-xs-12">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="txtestado">Estado <span class="required">*</span></label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select id="cmbestado" name="estado" class="form-control">
                                    <option value="A">Activo</option>
                                    <option value="I">Inactivo</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn_close_form_modal" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Grabar</button>
                    </div>

                    </div>
                </div>
            </div>
        </form>

        <form id="demo-form3" action="../controllers/contoller.php" method="POST" data-parsley-validate class="form-horizontal form-label-left">
            <input type="hidden" name="action" value="edit_permisos" />
            <div class="modal fade bs-example-modal-lg mperfil" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel">Permiso</h4>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="txtid" name="perfil">
                        <input type="hidden" name="max" value="<?php echo $max; ?>">
                        <?php
                        echo $html;
                        ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn_close_form_modal" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Grabar</button>
                    </div>

                    </div>
                </div>
            </div>
        </form>
        <!-- /page content -->

        <!-- footer content -->
        <footer>
          <div class="pull-right">
            Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>

    <!-- jQuery -->
    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="../vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="../vendors/nprogress/nprogress.js"></script>
    <!-- bootstrap-progressbar -->
    <script src="../vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- iCheck -->
    <script src="../vendors/iCheck/icheck.min.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="../vendors/moment/min/moment.min.js"></script>
    <script src="../vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
    <!-- bootstrap-wysiwyg -->
    <script src="../vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js"></script>
    <script src="../vendors/jquery.hotkeys/jquery.hotkeys.js"></script>
    <script src="../vendors/google-code-prettify/src/prettify.js"></script>
    <!-- jQuery Tags Input -->
    <script src="../vendors/jquery.tagsinput/src/jquery.tagsinput.js"></script>
    <!-- Switchery -->
    <script src="../vendors/switchery/dist/switchery.min.js"></script>
    <!-- Select2 -->
    <script src="../vendors/select2/dist/js/select2.full.min.js"></script>
    <!-- Parsley -->
    <script src="../vendors/parsleyjs/dist/parsley.min.js"></script>
    <!-- Autosize -->
    <script src="../vendors/autosize/dist/autosize.min.js"></script>
    <!-- jQuery autocomplete -->
    <script src="../vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js"></script>
    <!-- starrr -->
    <script src="../vendors/starrr/dist/starrr.js"></script>
    

    <script src="../vendors/pnotify/dist/pnotify.js"></script>
    <script src="../vendors/pnotify/dist/pnotify.buttons.js"></script>
    <script src="../vendors/pnotify/dist/pnotify.nonblock.js"></script>

    <!-- Datatables -->
    <script src="../vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="../vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="../vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="../vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="../vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
    <script src="../vendors/jszip/dist/jszip.min.js"></script>
    <script src="../vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="../vendors/pdfmake/build/vfs_fonts.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="../build/js/table.js"></script>
    
    <script>
      $( function() {
        $(".ui-pnotify-fade-normal").remove();
        $("#demo-form2").submit(function(e){
            e.preventDefault();
            editar_perfil();
        });
        $("#demo-form3").submit(function(e){
            e.preventDefault();
            editar_permiso();
        });
        $(".btn_modal_edit_form").click(function(){
            var perfil = $.parseJSON($(this).attr('data'));
            $("#txtidperfil").val(perfil.id);
            $("#nombre").val(perfil.nombre);
            $("#cmbestado").val(perfil.estado);
        });
        $(".btn_modal_edit_form_permiso").click(function(){
            var perfil    = $.parseJSON($(this).attr('data'));
            var permisos  = $.parseJSON($(this).attr('data_permiso'));
            var max = <?php echo $max; ?>;
            for(var i=1;i<=max;i++){
              $("#"+i).val(0);
            }
            $.each(permisos,function(index,data){
              $("#"+data.modulo).val(data.permiso);
            });
            $("#txtid").val(perfil.id);
        });

        function editar_perfil(){
            var base_url = window.location.origin;
            $.ajax({
                type: "POST",
                url: base_url + "/administrar/controllers/controller.php",
                data: $("#demo-form2").serialize(),
                beforeSend: function (qXHR, settings) {
                    notice = new PNotify({
                        title: 'Noticia',
                        type: 'info',
                        text: 'El sistema esta trabajando, espere un momento',
                        nonblock: {
                            nonblock: true
                        },
                        styling: 'bootstrap3',
                        addclass: 'dark'
                    });
                },
                complete: function () {
                    //resetForm("demo-form2");
                },
                success: function(result){
                    var json = $.parseJSON(result);
                    if(json.response=='fail'){
                        var mensaje = json.mensaje;
                        new PNotify({
                                  title: '!Advertencia',
                                  text: mensaje,
                                  styling: 'bootstrap3'
                              });
                    }else{
                        var mensaje = json.mensaje;
                        new PNotify({
                                  title: '!Exito',
                                  text: mensaje,
                                  type: 'success',
                                  styling: 'bootstrap3'
                              });
                        $(".btn_close_form_modal").trigger('click');
                    }
                },
                statusCode: {
                    404: function() {
                        var mensaje = "Page not Found";
                        new PNotify({
                                  title: 'Oh No!',
                                  text: mensaje,
                                  type: 'error',
                                  styling: 'bootstrap3'
                              });
                    },
                    500: function(result) {
                        var mensaje = "Error General";
                        new PNotify({
                                  title: 'Oh No!',
                                  text: mensaje,
                                  type: 'error',
                                  styling: 'bootstrap3'
                              });
                    }
                }
            });
        }
        function editar_permiso(){
            var base_url = window.location.origin;
            $.ajax({
                type: "POST",
                url: "<?php echo $_SESSION['url_base']; ?>"  + "/controllers/controller.php",
                data: $("#demo-form3").serialize(),
                beforeSend: function (qXHR, settings) {
                    notice = new PNotify({
                        title: 'Noticia',
                        type: 'info',
                        text: 'El sistema esta trabajando, espere un momento',
                        nonblock: {
                            nonblock: true
                        },
                        styling: 'bootstrap3',
                        addclass: 'dark'
                    });
                },
                complete: function () {
                    //resetForm("demo-form2");
                },
                success: function(result){
                    var json = $.parseJSON(result);
                    if(json.response=='fail'){
                        var mensaje = json.mensaje;
                        new PNotify({
                                  title: '!Advertencia',
                                  text: mensaje,
                                  styling: 'bootstrap3'
                              });
                    }else{
                        var mensaje = json.mensaje;
                        new PNotify({
                                  title: '!Exito',
                                  text: mensaje,
                                  type: 'success',
                                  styling: 'bootstrap3'
                              });
                        $(".btn_close_form_modal").trigger('click');
                    }
                },
                statusCode: {
                    404: function() {
                        var mensaje = "Page not Found";
                        new PNotify({
                                  title: 'Oh No!',
                                  text: mensaje,
                                  type: 'error',
                                  styling: 'bootstrap3'
                              });
                    },
                    500: function(result) {
                        var mensaje = "Error General";
                        new PNotify({
                                  title: 'Oh No!',
                                  text: mensaje,
                                  type: 'error',
                                  styling: 'bootstrap3'
                              });
                    }
                }
            });
        }
      });
    //editor-one
    </script>
  </body>
</html>
<?php 
$con->close();
?>