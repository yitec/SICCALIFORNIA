var year = new Date().getFullYear();
var month = new Date().getMonth();
var day = new Date().getDate();
var eve=new String();
var vari;
var v_eventos= Array();
var v_detalles= Array();
var eventData = { events : []};
	

$(document).ready(function() {
  	var $calendar = $('#calendar');
   	var id = 10;
   	obtiene_eventos();
    $calendar.weekCalendar({
      timeslotsPerHour: 4,
      timeslotHeigh: 30,
      hourLine: true,
      data: eventData,
      allowCalEventOverlap : true,
      overlapEventsSeparate: true,
      firstDayOfWeek : 1,
      businessHours :{start: 8, end: 18, limitDisplay: true },
      daysToShow : 7,
      switchDisplay: {'1 día': 1, '3 dias': 3, 'semana laboral': 5, 'Toda la semana': 7},
      title: function(daysToShow) {
			return daysToShow == 1 ? '%date%' : '%start% - %end%';
      },
      height: function($calendar) {
        return $(window).height() - $('h1').outerHeight(true);
      },	
      eventRender : function(calEvent, $event) {
         if (calEvent.end.getTime() < new Date().getTime()) {
            $event.css("backgroundColor", "#aaa");
            $event.find(".wc-time").css({
               "backgroundColor" : "#999",
               "border" : "1px solid #888"
            });
         }
      },
      draggable : function(calEvent, $event) {
         return calEvent.readOnly != true;
      },
      resizable : function(calEvent, $event) {
         return calEvent.readOnly != true;
      },      
      eventNew: function(calEvent, $event) {
        var $dialogContent = $("#event_edit_container");
         resetForm($dialogContent);
         var startField = $dialogContent.find("select[name='start']").val(calEvent.start);
         var endField = $dialogContent.find("select[name='end']").val(calEvent.end);
         var titleField = $dialogContent.find("input[name='title']");
         var bodyField = $dialogContent.find("textarea[name='body']");


         $dialogContent.dialog({
            modal: true,
            title: "Nuevo Evento",
            close: function() {
               $dialogContent.dialog("destroy");
               $dialogContent.hide();
               $('#calendar').weekCalendar("removeUnsavedEvents");
            },
            buttons: {
               save : function() {
                  calEvent.id = id;
                  id++;
                  calEvent.start = new Date(startField.val());
                  calEvent.end = new Date(endField.val());
                  calEvent.title = titleField.val();
                  calEvent.body = bodyField.val();
				  guarda_cita(new Date(startField.val()),new Date(endField.val()),titleField.val(),bodyField.val()) ;
                  $calendar.weekCalendar("removeUnsavedEvents");
                  $calendar.weekCalendar("updateEvent", calEvent);
                  $dialogContent.dialog("close");
               },
               cancel : function() {
                  $dialogContent.dialog("close");
               }
            }
         }).show();

         $dialogContent.find(".date_holder").text($calendar.weekCalendar("formatDate", calEvent.start));
         setupStartAndEndTimeFields(startField, endField, calEvent, $calendar.weekCalendar("getTimeslotTimes", calEvent.start));

      },
      eventDrop: function(calEvent, $event) {
        displayMessage('<strong>Moved Event</strong><br/>Start: ' + calEvent.start + '<br/>End: ' + calEvent.end);
      },
      eventResize: function(calEvent, $event) {
        displayMessage('<strong>Resized Event</strong><br/>Start: ' + calEvent.start + '<br/>End: ' + calEvent.end);
      },
      eventClick: function(calEvent, $event) {
         if (calEvent.readOnly) {
            return;
         }

         var $dialogContent = $("#event_edit_container");
         resetForm($dialogContent);
         var startField = $dialogContent.find("select[name='start']").val(calEvent.start);
         var endField = $dialogContent.find("select[name='end']").val(calEvent.end);
         var titleField = $dialogContent.find("input[name='title']").val(calEvent.title);
         var bodyField = $dialogContent.find("textarea[name='body']").val(calEvent.body);
         //bodyField.val(calEvent.body);

         $dialogContent.dialog({
            modal: true,
            title: "Edit - " + calEvent.title,
            close: function() {
               $dialogContent.dialog("destroy");
               $dialogContent.hide();
               $('#calendar').weekCalendar("removeUnsavedEvents");
            },
            buttons: {
               save : function() {

                  calEvent.start = new Date(startField.val());
                  calEvent.end = new Date(endField.val());
                  calEvent.title = titleField.val();
                  calEvent.body = bodyField.val();
				  modifica_cita(calEvent.id,new Date(startField.val()),new Date(endField.val()),titleField.val(),bodyField.val()) ;
                  $calendar.weekCalendar("updateEvent", calEvent);
                  $dialogContent.dialog("close");
               },
               "delete" : function() {
                  $calendar.weekCalendar("removeEvent", calEvent.id);
                  $dialogContent.dialog("close");
                  elimina_cita(calEvent.id) ;
               },
               cancel : function() {
                  $dialogContent.dialog("close");
               }
            }
         }).show();

         var startField = $dialogContent.find("select[name='start']").val(calEvent.start);
         var endField = $dialogContent.find("select[name='end']").val(calEvent.end);
         $dialogContent.find(".date_holder").text($calendar.weekCalendar("formatDate", calEvent.start));
         setupStartAndEndTimeFields(startField, endField, calEvent, $calendar.weekCalendar("getTimeslotTimes", calEvent.start));
         $(window).resize().resize(); //fixes a bug in modal overlay size ??


      },
      eventMouseover: function(calEvent, $event) {
        displayMessage('<strong>Mouseover Event</strong><br/>Start: ' + calEvent.start + '<br/>End: ' + calEvent.end);
      },
      eventMouseout: function(calEvent, $event) {
        displayMessage('<strong>Mouseout Event</strong><br/>Start: ' + calEvent.start + '<br/>End: ' + calEvent.end);
      },
      noEvents: function() {
        displayMessage('There are no events for this week');
      }
      
});//end document ready

    function displayMessage(message) {
      $('#message').html(message).fadeIn();
    }

	function resetForm($dialogContent) {
      $dialogContent.find("input").val("");
      $dialogContent.find("textarea").val("");
   }
	
   /*
    * Sets up the start and end time fields in the calendar event
    * form for editing based on the calendar event being edited
    */
   function setupStartAndEndTimeFields($startTimeField, $endTimeField, calEvent, timeslotTimes) {

      $startTimeField.empty();
      $endTimeField.empty();

      for (var i = 0; i < timeslotTimes.length; i++) {
         var startTime = timeslotTimes[i].start;
         var endTime = timeslotTimes[i].end;
         var startSelected = "";
         if (startTime.getTime() === calEvent.start.getTime()) {
            startSelected = "selected=\"selected\"";
         }
         var endSelected = "";
         if (endTime.getTime() === calEvent.end.getTime()) {
            endSelected = "selected=\"selected\"";
         }
         $startTimeField.append("<option value=\"" + startTime + "\" " + startSelected + ">" + timeslotTimes[i].startFormatted + "</option>");
         $endTimeField.append("<option value=\"" + endTime + "\" " + endSelected + ">" + timeslotTimes[i].endFormatted + "</option>");

         $timestampsOfOptions.start[timeslotTimes[i].startFormatted] = startTime.getTime();
         $timestampsOfOptions.end[timeslotTimes[i].endFormatted] = endTime.getTime();

      }
      $endTimeOptions = $endTimeField.find("option");
      $startTimeField.trigger("change");
   }

   var $endTimeField = $("select[name='end']");
   var $endTimeOptions = $endTimeField.find("option");
   var $timestampsOfOptions = {start:[],end:[]};

   //reduces the end time options to be only after the start time options.
   $("select[name='start']").change(function() {
      var startTime = $timestampsOfOptions.start[$(this).find(":selected").text()];
      var currentEndTime = $endTimeField.find("option:selected").val();
      $endTimeField.html(
            $endTimeOptions.filter(function() {
               return startTime < $timestampsOfOptions.end[$(this).text()];
            })
            );

      var endTimeSelected = false;
      $endTimeField.find("option").each(function() {
         if ($(this).val() === currentEndTime) {
            $(this).attr("selected", "selected");
            endTimeSelected = true;
            return false;
         }
      });

      if (!endTimeSelected) {
         //automatically select an end date 2 slots away.
         $endTimeField.find("option:eq(1)").attr("selected", "selected");
      }

   });
   


    $('<div id="message" class="ui-corner-all"></div>').prependTo($('body'));
  });
  
function obtiene_eventos(){	
	$.ajax({
    type: "POST",
	dataType: "json",
	async: false,
    url: "operaciones/opr_agenda.php",
    data: "id=1&func=eventos",
    success: function(datos){
		eve=datos.evento;
	}//end succces function
	});//end ajax function			
	v_eventos=eve.split("|");		
	var total=v_eventos.length;
	for(var i=0;i<v_eventos.length;i++){
		v_detalles=v_eventos[i].split("/");
		vari={"id":v_detalles[0], "start": v_detalles[1], "end": v_detalles[2],"title":v_detalles[3],"body":v_detalles[4]};
		eventData.events.push(vari);
	}	
}	

function guarda_cita(fecha_ini,fecha_fin,titulo,detalles){
	var usuario=1;
	$.ajax({
    type: "POST",
	dataType: "json",
	async: false,
    url: "operaciones/opr_agenda.php",
    data: "usuario="+usuario+"&fecha_ini="+fecha_ini+"&fecha_fin="+fecha_fin+"&titulo="+titulo+"&detalles="+detalles+"&func=agregar",
    success: function(datos){
		alert(datos.resultado);
	}//end succces function
	});//end ajax function			

}

function modifica_cita(id,fecha_ini,fecha_fin,titulo,detalles){
	var usuario=1;
	$.ajax({
    type: "POST",
	dataType: "json",
	async: false,
    url: "operaciones/opr_agenda.php",
    data: "id="+id+"&usuario="+usuario+"&fecha_ini="+fecha_ini+"&fecha_fin="+fecha_fin+"&titulo="+titulo+"&detalles="+detalles+"&func=modificar",
    success: function(datos){
		alert(datos.resultado);
	}//end succces function
	});//end ajax function			

}

function elimina_cita(id){
	var usuario=1;
	$.ajax({
    type: "POST",
	dataType: "json",
	async: false,
    url: "operaciones/opr_agenda.php",
    data: "id="+id+"&func=eliminar",
    success: function(datos){
		alert(datos.resultado);
	}//end succces function
	});//end ajax function			

}
