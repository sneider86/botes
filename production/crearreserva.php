<?php
session_start();
require_once 'session.php';
if(!isset($_SESSION['permisos'][3]) || $_SESSION['permisos'][3]!=1){
  header('Location:index.php?v='.date('his'));
}
$_SESSION['catering'] = array();
$_SESSION['reserva'] = 0;
if(isset($_SESSION['fecha'])){
  unset($_SESSION['fecha']);
}
if(isset($_SESSION['pasajeros'])){
  unset($_SESSION['pasajeros']);
}
if(isset($_SESSION['bote'])){
  unset($_SESSION['bote']);
}

require_once '../config/configbd.php';
$con        = new mysqli($bd['host'],$bd['user'],$bd['pass'],$bd['data']);
$con->set_charset("utf8");
$sql        = "SELECT id,nombre FROM wp_es_planes WHERE estado='A'";
$rsplanes   = $con->query($sql);
$sql        = "SELECT id,nombre FROM wp_es_botes WHERE estado='A'";
$rsbotes    = $con->query($sql);
$sql        = "SELECT MAX(pasajeros) as maximo FROM wp_es_botes WHERE estado='A'";
$rsmax      = $con->query($sql);


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
    <link href="../vendors/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="../build/css/custom.min.css" rel="stylesheet">
    <style>
      .boxcatering{
        display: inline-block; 
        margin-top:30px; 
        -webkit-box-shadow: 0px 0px 4px 0px rgba(0,0,0,0.3);
        -moz-box-shadow: 0px 0px 4px 0px rgba(0,0,0,0.3);
        box-shadow: 0px 0px 4px 0px rgba(0,0,0,0.3);
      }
    </style>
  </head>

  <body class="nav-md">
      <form id="demo-form2"></form>
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
                <?php
                  include_once 'menu_perfil.php';
                ?>

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
                <h3>Reserva</h3>
              </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                  <div class="x_title">
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div class="col-lg-8 col-md-6 col-sm-6 col-xs-6">
                      <form id="form_reserva" action="../controllers/contoller.php" method="POST" data-parsley-validate class="form-horizontal form-label-left">
                          <input type="hidden" name="action" value="crear_reserva" />
                          <input type="hidden" name="idPerfil" value="<?php echo $_SESSION['idPerfil']; ?>">
                          
                          <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="estado">Planes <span class="required">*</span>
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                  <select id="planes" name="planes" class="form-control">
                                    <?php
                                      if($rsplanes->num_rows>=1){
                                        while($item = $rsplanes->fetch_assoc()){
                                          echo '<option value="'.$item['id'].'">'.$item['nombre'].'</option>';
                                        }
                                      }
                                    ?>
                                  </select>
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="estado">Fecha <span class="required">*</span>
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="fecha" name="fecha" readonly="readonly" required="required" class="form-control col-md-7 col-xs-12">
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pasajeros">Pasajeros <span class="required">*</span>
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <select id="pasajeros" name="pasajeros" class="form-control">
                                  <?php
                                    if($rsmax->num_rows>=1){
                                      $item = $rsmax->fetch_assoc();
                                      for($i=1;$i<=intval($item['maximo']);$i++){
                                        echo '<option value="'.$i.'">'.$i.'</option>';
                                      }
                                    }
                                  ?>
                                </select>
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pasajeros">Botes <span class="required">*</span>
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <select id="botes" name="botes" class="form-control">
                                </select>
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pasajeros">Documento Cliente <span class="required">*</span>
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="documento" name="documento" required="required" class="form-control col-md-7 col-xs-12">
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pasajeros">Observaciones 
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <textarea type="text" id="desc" name="desc" class="form-control col-md-7 col-xs-12"></textarea>
                              </div>
                          </div>
                        <!----------------------- catering------------------------------->
                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <div class="x_panel">
                            <div class="x_title">
                              <h2>Catering</h2>
                              <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                              <br>
                              <form id="form_catering" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">
                              <?php
                              $sql          = "SELECT id,nombre,descipcion,urlimage,precio FROM wp_es_adicionales WHERE estado='A'";
                              $rskatering   = $con->query($sql);
                              if($rskatering->num_rows>=1){
                                while($item = $rskatering->fetch_assoc()){
                                  ?>
                                  <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                    <div class="boxcatering" >

                                      <input type="hidden" name="valcat" class="valcat" value="<?php echo $item['precio']; ?>" />
                                      <div class="content_image" style="text-align: center;">
                                        <img width="200px" src="images/catering/<?php echo $item['urlimage']; ?>" alt="<?php echo $item['nombre']; ?>" title="<?php echo $item['nombre']; ?>" />
                                      </div>
                                      <div class="content_name" style="text-align: center;">
                                        <label class="control-label" ><?php echo $item['nombre']; ?></span>
                                      </div>
                                      <div class="content_precio" style="text-align: center;">
                                        <label class="control-label" >$<?php echo number_format($item['precio'],0,'.',','); ?></span>
                                      </div>
                                      <div class="content_cant clearfix" style="text-align: center;">
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4" >
                                          <button type="button" data-nombre="<?php echo $item['nombre']; ?>" data-val="<?php echo $item['precio']; ?>" data-id="<?php echo $item['id']; ?>" class="btn btn-success menos">-</button>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4" style="text-align:center;">
                                          <input type="hidden" value="0" name="cant" >
                                          <label class="control-label lcant" >0</span>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                          <button type="button" data-nombre="<?php echo $item['nombre']; ?>" data-val="<?php echo $item['precio']; ?>" data-id="<?php echo $item['id']; ?>" class="btn btn-success mas">+</button>
                                        </div>
                                        
                                      </div>
                                    </div>
                                    
                                  </div>
                                  <?php
                                }
                                
                              }

                              ?>
                                

                              </form>
                            </div>
                          </div>
                        </div>
                        <!----------------------- catering ------------------------------->

                        <div class="form-group">
                          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                              <button class="btn btn-primary" type="button">Cancel</button>
                              <button class="btn btn-primary" type="reset">Reset</button>
                              <button type="submit" id="guardar" class="btn btn-success">Guardar</button>
                          </div>
                        </div>
                      </form>
                    </div>
                    <div id="htmlresumen">
                    </div>
                    
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->

        <!-- footer content -->
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

    <script src="../vendors/jQuery-Smart-Wizard/js/jquery.smartWizard.js"></script>

    <script src="../vendors/moment/min/moment.min.js"></script>
    <script src="../vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
    <!-- bootstrap-datetimepicker -->    
    <script src="../vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>


    <!-- FastClick -->
    <script src="../vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <!-- bootstrap-daterangepicker -->
    <script src="../vendors/moment/min/moment.min.js"></script>
    <script src="../vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
    <!-- bootstrap-datetimepicker -->    
    <script src="../vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
    <!-- Ion.RangeSlider -->
    <script src="../vendors/ion.rangeSlider/js/ion.rangeSlider.min.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="../build/js/custom.js"></script>

    <script src="../vendors/pnotify/dist/pnotify.js"></script>
    <script src="../vendors/pnotify/dist/pnotify.buttons.js"></script>
    <script src="../vendors/pnotify/dist/pnotify.nonblock.js"></script>
    
    <script>
      $( function() {
        $(".mas").click(function(){
          var val = parseInt($(this).parents('.content_cant').find('input').val());
          val = val+1;
          var precio = parseInt( $(this).attr("data-val") ) * val;
          var nombre = $(this).attr("data-nombre");
          var id = $(this).attr("data-id");
          $(this).parents('.content_cant').find('input').val(val);
          $(this).parents('.content_cant').find('.lcant').html(val);

          $.ajax({
            type: "POST",
            url: "<?php echo $_SESSION['url_base']; ?>"  + "/controllers/controller.php?v=<?php echo date('his'); ?>",
            data: {
              action:'modificar_catering',
              val:val,
              precio:precio,
              nombre:nombre,
              id:id
            },
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
            },
            success: function(result){
              load_resumen('');
              //var json = $.parseJSON(result);
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

        });
        $(".menos").click(function(){
          var val = parseInt($(this).parents('.content_cant').find('input').val());
          val = val-1;
          
          if(val>=0){
            var precio = parseInt( $(this).attr("data-val") ) * val;
            var nombre = $(this).attr("data-nombre");
            var id = $(this).attr("data-id");
            $(this).parents('.content_cant').find('input').val(val);
            $(this).parents('.content_cant').find('.lcant').html(val);
            $.ajax({
              type: "POST",
              url: "<?php echo $_SESSION['url_base']; ?>"  + "/controllers/controller.php?v=<?php echo date('his'); ?>",
              data: {
                action:'modificar_catering',
                val:val,
                precio:precio,
                nombre:nombre,
                id:id
              },
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
              },
              success: function(result){
                load_resumen('');
                //var json = $.parseJSON(result);
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
          }else{
            load_resumen('');
          }

          
        });
        $('#fecha').datetimepicker({
            ignoreReadonly: true,
            allowInputToggle: true,
            format: 'DD/MM/YYYY'
        })
        .on('dp.change', function (e) { 
          load_bote();
        });
        $(".ui-pnotify-fade-normal").remove();
        $("#guardar").click(function(e){
            crear_reserva();
        });
        $("#pasajeros").change(function(){
          load_bote('');
        });
        $("#planes").change(function(){
          load_bote('');
        });
        $("#botes").change(function(){
          load_bote('subaction');
        });

        function load_bote(subaction){
          var plan      = $("#planes").val();
          var fecha     = $("#fecha").val();
          var pasajeros = $("#pasajeros").val();
          var botes = $("#botes").val();
          if(plan>0 && fecha!='' && pasajeros>0){
            $.ajax({
              type: "POST",
              url: "<?php echo $_SESSION['url_base']; ?>"  + "/controllers/controller.php?v=<?php echo date('his'); ?>",
              data: {
                action:'cargar_bote_reserva',
                plan:plan,
                fecha:fecha,
                pasajeros:pasajeros,
                botes:botes,
                subaction:subaction,
                idPerfil: <?php echo $_SESSION['idPerfil']; ?>
              },
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
                  load_resumen();
                  var mensaje = json.mensaje;
                  var data = json.data;
                  var options = "";
                  $.each(data,function(index,element){
                    options = options + "<option value='"+element.id+"'>"+element.nombre+"</option>";
                  });
                  if(subaction!="subaction"){
                    $("#botes").html(options);
                    if(botes!="" && botes>0){
                      $("#botes").val(botes);
                    }
                  }
                  //botes
                  new PNotify({
                    title: '!Exito',
                    text: mensaje,
                    type: 'success',
                    styling: 'bootstrap3'
                  });
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
        }
        function load_resumen(){
          var botes = $("#botes").val();
          $.ajax({
                type: "POST",
                url: "<?php echo $_SESSION['url_base']; ?>"  + "/controllers/controller.php?v=<?php echo date('his'); ?>",
                data: {
                  action:'load_resumen_admin',
                  idPerfil: <?php echo $_SESSION['idPerfil']; ?>
                },
                beforeSend: function (qXHR, settings) {

                },
                complete: function () {
                },
                success: function(result){
                    var json = $.parseJSON(result);
                    if(json.response=='fail'){
                      var mensaje = json.mensaje;

                    }else{
                      $("#htmlresumen").html(json.html);
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
        function crear_reserva(){
            $.ajax({
                type: "POST",
                url: "<?php echo $_SESSION['url_base']; ?>"  + "/controllers/controller.php?v=<?php echo date('his'); ?>",
                data: $("#form_reserva").serialize(),
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
    </script>
  </body>
</html>
