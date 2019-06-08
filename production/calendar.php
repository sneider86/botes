<?php
require_once 'session.php';
if(!isset($_SESSION['permisos'][2]) || $_SESSION['permisos'][2]!=1){
  header('Location:index.php?v='.date('his'));
}
?>
<!DOCTYPE html>
<html lang="es">
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
    <!-- FullCalendar -->
    <link href="../vendors/fullcalendar/dist/fullcalendar.min.css" rel="stylesheet">
    <link href="../vendors/fullcalendar/dist/fullcalendar.print.css" rel="stylesheet" media="print">

     <!-- PNotify -->
     <link href="../vendors/pnotify/dist/pnotify.css" rel="stylesheet">
    <link href="../vendors/pnotify/dist/pnotify.buttons.css" rel="stylesheet">
    <link href="../vendors/pnotify/dist/pnotify.nonblock.css" rel="stylesheet">

    <!-- Custom styling plus plugins -->
    <link href="../build/css/custom.min.css" rel="stylesheet">
    <style>
      .btnizq{
        float: left;
      }
      .dataTables_wrapper .row:first-child,
      .dataTables_info{
        display:none;
      }
    </style>
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
            <div class="sidebar-footer hidden-small">
              <a data-toggle="tooltip" data-placement="top" title="Settings">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Logout" href="login.html">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
            </div>
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
                <h3>Agendamiento <small></small></h3>
              </div>

            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Calendario </h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                    <div id='calendar'></div>

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

    <!-- calendar modal -->
    <div id="CalenderModalNew" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">

          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="myModalLabel">New Calendar Entry</h4>
          </div>
          <div class="modal-body">
            <div id="testmodal" style="padding: 5px 20px;">
              <form id="antoform" class="form-horizontal calender" role="form">
                <div class="form-group">
                  <label class="col-sm-3 control-label">Titulo</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="title" name="title">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">Descripci&oacute;n</label>
                  <div class="col-sm-9">
                    <textarea class="form-control" style="height:55px;" id="descr" name="descr"></textarea>
                  </div>
                </div>
              </form>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default antoclose" data-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-primary antosubmit">Grabar Cambios</button>
          </div>
        </div>
      </div>
    </div>
    <div id="CalenderModalEdit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">

          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="myModalLabel2">Reserva</h4>
          </div>
          <div class="modal-body">

            <div id="testmodal2" style="padding: 5px 20px;">
              <form id="antoform2" class="form-horizontal calender" role="form">
                <div class="form-group">
                  <label class="col-sm-3 control-label">Bote</label>
                  <div class="col-sm-9">
                    <input type="text" readonly="readonly" class="form-control" id="title2" name="title2">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">Descripci&oacute;n</label>
                  <div class="col-sm-9">
                    <textarea class="form-control" style="height:250px;" readonly="readonly" id="descr2" name="descr"></textarea>
                  </div>
                </div>

              </form>
            </div>
          </div>
          <input type="hidden" id="idshedule" />
          <div class="modal-footer">
            <button type="button" id="btneliminar" class="btn btn-default btn-danger btnizq" data-dismiss="modal">Eliminar</button>
            <button type="button" class="btn btn-default antoclose2" data-dismiss="modal">Cerrar</button>
            <button type="button" id="btnabonos" data-toggle="modal" data-target=".modal_abonos" class="btn btn-primary">Abonos</button>
          </div>
        </div>
      </div>
    </div>

    <div id="modal_abonos" class="modal fade modal_abonos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">

          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="myModalLabel2">Abonos</h4>
          </div>
          <div class="modal-body">

            <div id="content_table" style="padding: 5px 20px;">
              
            </div>
          </div>
          <input type="hidden" id="idshedule" />
          <div class="modal-footer">
            <button type="button" id="btnsendmail" class="btn btn-default btn-danger btnizq">Notificar</button>
            <button type="button" class="btn btn-default antoclose2" data-dismiss="modal">Cerrar</button>
            <button type="button" data-toggle="modal" data-target=".modal_add_abonos" class="btn btn-primary">Nuevo</button>
          </div>
        </div>
      </div>
    </div>

    <div id="modal_add_abonos" class="modal fade modal_add_abonos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">

          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="myModalLabel2">Abono</h4>
          </div>
          <div class="modal-body">
            <div id="testmodal2" style="padding: 5px 20px;">
              <form id="frmvalor" class="form-horizontal" role="form">
                <div class="form-group">
                  <label class="col-sm-3 control-label">Valor <span class="required">*</span></label>
                  <div class="col-sm-9">
                  <input type="text"  class="form-control" required="required" id="txtvalor" name="valor">
                  </div>
                </div>
              </form>
            </div>
            
            
          </div>
          <input type="hidden" id="idshedule" />
          <div class="modal-footer">
            <button type="button" class="btn btn-default antoclose2" data-dismiss="modal">Cerrar</button>
            <button type="button" id="btnbuevoabono" class="btn btn-primary">Nuevo</button>
          </div>
        </div>
      </div>
    </div>

    <div id="fc_create" data-toggle="modal" data-target="#CalenderModalNew"></div>
    <div id="fc_edit" data-toggle="modal" data-target="#CalenderModalEdit"></div>
    <!-- /calendar modal -->
        
    <!-- jQuery -->
    <script src="../vendors/jquery/dist/jquery.min.js"></script>

    
    <!-- Bootstrap -->
    <script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    
    <script src="../vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="../vendors/nprogress/nprogress.js"></script>
    <!-- FullCalendar -->
    <script src="../vendors/moment/min/moment.min.js"></script>
    <script src="../vendors/fullcalendar/dist/fullcalendar.min.js"></script>

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

    <!-- Custom Theme Scripts -->
    <!-- <script src="../build/js/custom.min.js"></script> -->
    <script src="../build/js/data_calendar.js<?php echo '?v='.date('his'); ?>"></script>
    <script>
      $(function(){

        $("#btnabonos").click(function(){
          load_abonos();
        });

        //$('#datatableabonos').dataTable();
        

        $("#btneliminar").click(function(){
          eliminar_reserva();
        });
        function eliminar_reserva(){
          var id = $("#idshedule").val();
          $.ajax({
              type: "POST",
              url: "<?php echo $_SESSION['url_base']; ?>"  + "/controllers/controller.php",
              data: {
                action:'eliminar_reserva',
                id:id
              },
              beforeSend: function (qXHR, settings) {

              },
              complete: function () {
                  //resetForm("demo-form2");
              },
              success: function(result){
                  var json = $.parseJSON(result);
                  if(json.response=='fail'){
                      var mensaje = json.mensaje;
                  }else{
                      var mensaje = json.mensaje;
                      new PNotify({
                                title: '!Exito',
                                text: mensaje,
                                type: 'success',
                                styling: 'bootstrap3'
                            });
                      window.location.href = 'calendar.php?v=<?php echo date('his'); ?>';
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
        function load_abonos(){
          var id = $("#idshedule").val();
          $.ajax({
              type: "POST",
              url: "<?php echo $_SESSION['url_base']; ?>"  + "/controllers/controller.php",
              data: {
                action:'load_abonos',
                id:id
              },
              beforeSend: function (qXHR, settings) {

              },
              complete: function () {
                  //resetForm("demo-form2");
              },
              success: function(result){
                //content_table
                  var json = $.parseJSON(result);
                  if(json.response=='fail'){
                      var mensaje = json.mensaje;
                  }else{
                      $("#content_table").html(json.html);
                      $("#txtvalor").val('');
                      init_DataTables();
                      $(".btn_aprobar_abono").click(function(){
                        var idAbono = $(this).attr("data-id");
                        aprobar(idAbono);
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
      function init_DataTables() {
        if( typeof ($.fn.DataTable) === 'undefined'){ return; }
        
        var handleDataTableButtons = function() {
          if ($("#datatable-buttons").length) {
          $("#datatable-buttons").DataTable({
            dom: "Blfrtip",
            buttons: [
            {
              extend: "copy",
              className: "btn-sm"
            },
            {
              extend: "csv",
              className: "btn-sm"
            },
            {
              extend: "excel",
              className: "btn-sm"
            },
            {
              extend: "pdfHtml5",
              className: "btn-sm"
            },
            {
              extend: "print",
              className: "btn-sm"
            },
            ],
            responsive: true
          });
          }
        };

        TableManageButtons = function() {
          "use strict";
          return {
          init: function() {
            handleDataTableButtons();
          }
          };
        }();

        $('#datatable').dataTable();

        $('#datatable-keytable').DataTable({
          keys: true
        });

        $('#datatable-responsive').DataTable();

        $('#datatable-scroller').DataTable({
          ajax: "js/datatables/json/scroller-demo.json",
          deferRender: true,
          scrollY: 380,
          scrollCollapse: true,
          scroller: true
        });

        $('#datatable-fixed-header').DataTable({
          fixedHeader: true
        });

        var $datatable = $('#datatable-checkbox');

        $datatable.dataTable({
          'order': [[ 1, 'asc' ]],
          'columnDefs': [
          { orderable: false, targets: [0] }
          ]
        });
        $datatable.on('draw.dt', function() {
          $('checkbox input').iCheck({
          checkboxClass: 'icheckbox_flat-green'
          });
        });

        TableManageButtons.init();
        
      };
      $("#btnbuevoabono").click(function(){
        nuevoAbono();
      });
      function nuevoAbono(){
        var id = $("#idOrdenAbondo").val();
        var valor=$("#txtvalor").val();
        $.ajax({
          type: "POST",
          url: "<?php echo $_SESSION['url_base']; ?>"  + "/controllers/controller.php",
          data: {
            action:'add_abono',
            id:id,
            valor:valor
          },
          beforeSend: function (qXHR, settings) {

          },
          complete: function () {
              //resetForm("demo-form2");
          },
          success: function(result){
              var json = $.parseJSON(result);
              if(json.response=='fail'){
                  var mensaje = json.mensaje;
              }else{
                var mensaje = json.mensaje;
                new PNotify({
                          title: '!Exito',
                          text: mensaje,
                          type: 'success',
                          styling: 'bootstrap3'
                      });
                window.location.href = 'calendar.php?v=<?php echo date('his'); ?>';
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
      function aprobar(idAbono){
        $.ajax({
          type: "POST",
          url: "<?php echo $_SESSION['url_base']; ?>"  + "/controllers/controller.php",
          data: {
            action:'aprobar_abono',
            idAbono:idAbono
          },
          beforeSend: function (qXHR, settings) {

          },
          complete: function () {
              //resetForm("demo-form2");
          },
          success: function(result){
              var json = $.parseJSON(result);
              if(json.response=='fail'){
                  var mensaje = json.mensaje;
              }else{
                var mensaje = json.mensaje;
                new PNotify({
                          title: '!Exito',
                          text: mensaje,
                          type: 'success',
                          styling: 'bootstrap3'
                      });
                window.location.href = 'calendar.php?v=<?php echo date('his'); ?>';
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
      $("#btnsendmail").click(function(){
        notificar();
      });
      function notificar(){
        var agenda = $("#idshedule").val();
        $.ajax({
          type: "POST",
          url: "<?php echo $_SESSION['url_base']; ?>"  + "/controllers/controller.php",
          data: {
            action:'notificar_total_abonos',
            agenda:agenda
          },
          beforeSend: function (qXHR, settings) {

          },
          complete: function () {
              //resetForm("demo-form2");
          },
          success: function(result){
              var json = $.parseJSON(result);
              if(json.response=='fail'){
                  var mensaje = json.mensaje;
              }else{
                var mensaje = json.mensaje;
                new PNotify({
                          title: '!Exito',
                          text: mensaje,
                          type: 'success',
                          styling: 'bootstrap3'
                      });
                window.location.href = 'calendar.php?v=<?php echo date('his'); ?>';
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
    </script>

  </body>
</html>