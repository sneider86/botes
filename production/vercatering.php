<?php 
require_once 'session.php';
if(!isset($_SESSION['permisos'][19]) || $_SESSION['permisos'][19]!=1){
  header('Location:index.php?v='.date('his'));
}
require_once '../config/configbd.php';
$con        = new mysqli($bd['host'],$bd['user'],$bd['pass'],$bd['data']);
$con->set_charset("utf8");
$sql        = "SELECT id,nombre,descipcion,precio,estado FROM wp_es_adicionales";
$rscatering = $con->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
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
                <h3>Catering</h3>
              </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Ver Catering </h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                    <div class="col-md-12 col-sm-6 col-xs-12">
                    <table id="datatable" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>Nombre</th>
                          <th>Descripci&oacute;n</th>
                          <th>Precio</th>
                          <th>Estado</th>
                          <th>Acci&oacute;n</th>
                        </tr>
                      </thead>
                      <tbody>
                          <?php
                            if($rscatering->num_rows>=1){
                                while($item = $rscatering->fetch_assoc()){
                                    echo '<tr>';
                                    echo '<td>'.$item['nombre'].'</td>';
                                    echo '<td>'.$item['descipcion'].'</td>';
                                    echo '<td>$'.  number_format($item['precio'],0,".",",")  .'</td>';
                                    echo '<td>'.$item['estado'].'</td>';
                                    echo '<td><button type="button" data=\''.json_encode($item).'\'" class="btn btn-primary btn_modal_edit_form" data-toggle="modal" data-target=".bs-example-modal-lg">Editar</button></td>';
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

        <form id="demo-form2" enctype="multipart/form-data" action="../controllers/contoller.php" method="POST" data-parsley-validate class="form-horizontal form-label-left">
            <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel">Precio</h4>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="txtid" name="id">
                        <input type="hidden" name="action" value="editar_catering" />
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="botes">Nombre <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="nombre" name="nombre" required="required" class="form-control col-md-7 col-xs-12">   
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="plan">Descripci&oacute;n <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="descripcion" name="descripcion" required="required" class="form-control col-md-7 col-xs-12">   
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="precio">Precio <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="precio" name="precio" placeholder="ej. 2400000" required="required" class="form-control col-md-7 col-xs-12">
                            </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="imagen">Imagen 
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="file" id="imagen" name="imagen" class="form-control col-md-7 col-xs-12">
                          </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="estado">Estado <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select id="estado" name="estado" class="form-control">
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
            editar_catering();
        });

        $('#datatable').on( 'draw.dt', function () {
          $(".btn_modal_edit_form").off('click');
          $(".btn_modal_edit_form").on('click',function(){
            var catering = $.parseJSON($(this).attr('data'));
            $("#txtid").val(catering.id);
            $("#nombre").val(catering.nombre);
            $("#descripcion").val(catering.descipcion);
            $("#precio").val(catering.precio);
            $("#estado").val(catering.estado);
          });
        } );

        $(".btn_modal_edit_form").on('click',function(){
          var catering = $.parseJSON($(this).attr('data'));
            $("#txtid").val(catering.id);
            $("#nombre").val(catering.nombre);
            $("#descripcion").val(catering.descipcion);
            $("#precio").val(catering.precio);
            $("#estado").val(catering.estado);
        });

        function editar_catering(){
          var formElement = document.getElementById("demo-form2");
            $.ajax({
                type: "POST",
                url: "<?php echo $_SESSION['url_base']; ?>"  + "/controllers/controller.php",

                data:  new FormData(formElement),
                contentType: false,
                cache: false,
                processData:false,

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