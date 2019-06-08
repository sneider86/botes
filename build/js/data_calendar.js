// Sidebar
var CURRENT_URL = window.location.href.split('#')[0].split('?')[0],
    $BODY = $('body'),
    $MENU_TOGGLE = $('#menu_toggle'),
    $SIDEBAR_MENU = $('#sidebar-menu'),
    $SIDEBAR_FOOTER = $('.sidebar-footer'),
    $LEFT_COL = $('.left_col'),
    $RIGHT_COL = $('.right_col'),
    $NAV_MENU = $('.nav_menu'),
		$FOOTER = $('footer');

		(function($,sr){
			// debouncing function from John Hann
			// http://unscriptable.com/index.php/2009/03/20/debouncing-javascript-methods/
			var debounce = function (func, threshold, execAsap) {
				var timeout;
	
					return function debounced () {
							var obj = this, args = arguments;
							function delayed () {
									if (!execAsap)
											func.apply(obj, args); 
									timeout = null; 
							}
	
							if (timeout)
									clearTimeout(timeout);
							else if (execAsap)
									func.apply(obj, args);
	
							timeout = setTimeout(delayed, threshold || 100); 
					};
			};
	
			// smartresize 
			jQuery.fn[sr] = function(fn){  return fn ? this.bind('resize', debounce(fn)) : this.trigger(sr); };
	
	})(jQuery,'smartresize');
		
function init_sidebar() {
	// TODO: This is some kind of easy fix, maybe we can improve this
	var setContentHeight = function () {
		// reset height
		$RIGHT_COL.css('min-height', $(window).height());
	
		var bodyHeight = $BODY.outerHeight(),
			footerHeight = $BODY.hasClass('footer_fixed') ? -10 : $FOOTER.height(),
			leftColHeight = $LEFT_COL.eq(1).height() + $SIDEBAR_FOOTER.height(),
			contentHeight = bodyHeight < leftColHeight ? leftColHeight : bodyHeight;
	
		// normalize content
		contentHeight -= $NAV_MENU.height() + footerHeight;
	
		$RIGHT_COL.css('min-height', contentHeight);
	};
	
		$SIDEBAR_MENU.find('a').on('click', function(ev) {
					var $li = $(this).parent();
	
					if ($li.is('.active')) {
							$li.removeClass('active active-sm');
							$('ul:first', $li).slideUp(function() {
									setContentHeight();
							});
					} else {
							// prevent closing menu if we are on child menu
							if (!$li.parent().is('.child_menu')) {
									$SIDEBAR_MENU.find('li').removeClass('active active-sm');
									$SIDEBAR_MENU.find('li ul').slideUp();
							}else
							{
					if ( $BODY.is( ".nav-sm" ) )
					{
						$li.parent().find( "li" ).removeClass( "active active-sm" );
						$li.parent().find( "li ul" ).slideUp();
					}
				}
							$li.addClass('active');
	
							$('ul:first', $li).slideDown(function() {
									setContentHeight();
							});
					}
			});
	
	// toggle small or large menu 
	$MENU_TOGGLE.on('click', function() {
			console.log('clicked - menu toggle');
			
			if ($BODY.hasClass('nav-md')) {
				$SIDEBAR_MENU.find('li.active ul').hide();
				$SIDEBAR_MENU.find('li.active').addClass('active-sm').removeClass('active');
			} else {
				$SIDEBAR_MENU.find('li.active-sm ul').show();
				$SIDEBAR_MENU.find('li.active-sm').addClass('active').removeClass('active-sm');
			}
	
		$BODY.toggleClass('nav-md nav-sm');
	
		setContentHeight();
	
		$('.dataTable').each ( function () { $(this).dataTable().fnDraw(); });
	});
	
		// check active menu
		$SIDEBAR_MENU.find('a[href="' + CURRENT_URL + '"]').parent('li').addClass('current-page');
	
		$SIDEBAR_MENU.find('a').filter(function () {
			return this.href == CURRENT_URL;
		}).parent('li').addClass('current-page').parents('ul').slideDown(function() {
			setContentHeight();
		}).parent().addClass('active');
	
		// recompute content when resizing
		$(window).smartresize(function(){  
			setContentHeight();
		});
	
		setContentHeight();
	
		// fixed sidebar
		if ($.fn.mCustomScrollbar) {
			$('.menu_fixed').mCustomScrollbar({
				autoHideScrollbar: true,
				theme: 'minimal',
				mouseWheel:{ preventDefault: true }
			});
		}
	};
	// /Sidebar
function  init_calendar_data(events_shedule) {
	var data = {};
	if( typeof ($.fn.fullCalendar) === 'undefined'){ return; }
		var data = { 
			title : "check",
			allDay : true,
			start : new Date(1986,3,2,15,30)
		} 
		var calendar = $('#calendar').fullCalendar({
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay,listMonth'
			},
			selectable: true,
			selectHelper: true,
			select: function(start, end, allDay) {
			$('#fc_create').click();
			started = start;
			ended = end;
			$(".antosubmit").on("click", function() {
				var title = $("#title").val();
				if (end) {
					ended = end;
				}
				categoryClass = $("#event_type").val();
				if (title) {
					calendar.fullCalendar('renderEvent', {
						title: title,
						start: started,
						end: end,
						allDay: allDay
						},
						true // make the event "stick"
					);
				}
				$('#title').val('');
				calendar.fullCalendar('unselect');
				$('.antoclose').click();
				return false;
			});
			},
				  eventClick: function(calEvent, jsEvent, view) {
					$('#fc_edit').click();
					$('#title2').val(calEvent.bote);
					$("#idshedule").val(calEvent.id);
					var texto = "Documento: "+calEvent.documento+"\nNombre: "+calEvent.nombre+"\nApellido: "+calEvent.apellido+"\nEmail: "+calEvent.email+"\nBote: "+calEvent.bote  +"\nPlan: "+calEvent.plan+"\nPersonas: "+calEvent.cant+"\nFecha: "+calEvent.fechareal+"\nTotal: "+calEvent.total+"\nFranja Horaria: "+calEvent.horario+"\nAbono: "+calEvent.abono;
					$.each(calEvent.catering,function(index,element){
						var txtcatering = element.nombre+" x"+element.cant+"  "+element.total
						texto=texto+"\n"+txtcatering;
					});
					texto=texto+"\nCodigo de Reserva: "+calEvent.codigoreserva;
					texto=texto+"\nSaldo: "+calEvent.saldo;
					texto=texto+"\nObservaciones: "+calEvent.observacion;
					
					$("#descr2").val(texto);
					categoryClass = $("#event_type").val();

					$(".antosubmit2").on("click", function() {
					  calEvent.title = $("#title2").val();

					  calendar.fullCalendar('updateEvent', calEvent);
					  $('.antoclose2').click();
					});

					calendar.fullCalendar('unselect');
				  },
				  editable: true,
				  events: [data]
                });
                $.each(events_shedule,function(index,element){
                    data = { 
                        title : element.bote+" - "+element.horario,
                        allDay : element.allDay,
						start : new Date(element.year,element.month,element.day,element.hour,element.min),
						documento: element.documento,
						bote: element.bote,
						plan : element.title,
						cant : element.npersona,
						fecha: element.day+"/"+element.month+"/"+element.year,
						nombre : element.nombre,
						apellido : element.apellido,
						email : element.email,
						total : element.total,
						horario : element.horario,
						id : element.id,
						abono : element.abono,
						saldo : element.saldo,
						catering: element.catering,
						codigoreserva: element.codigoreserva,
						observacion: element.observa,
						fechareal: element.day+"/"+(element.month+1)+"/"+element.year,
                    } 
                    calendar.fullCalendar( 'renderEvent', data, true );
                });
			};
	   



	$(document).ready(function() {
				
		init_sidebar();
        
        var base_url = window.location.origin;
        
        $.ajax({
            type: "POST",
            url: base_url + "/administrar/controllers/events_shedule.php",
            beforeSend: function (qXHR, settings) {
                //$("#zonamensajes").html('');
            },
            complete: function () {
                
            },
            success: function(result){
                var json = $.parseJSON(result);
                if(json.response != 'fail'){
                    init_calendar_data(json.data);
                }
            },
            statusCode: {
                404: function() {
                    var mensaje = "Page not Found";
                    //$("#zonamensajes").html('<div class="alert alert-warning alert-dismissible fade show" role="alert"><strong>Advertencia!</strong> '+mensaje+'. <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button></div>');
                }
            }
        });
        
    //     init_compose();
		// init_CustomNotification();
		// init_autosize();
		// init_autocomplete();
				
	});	
	

