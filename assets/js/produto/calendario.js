$(document).ready(function(){

    var date = new Date()
    var d    = date.getDate(),
        m    = date.getMonth(),
        y    = date.getFullYear()

    var Calendar = FullCalendar.Calendar;
    var Draggable = FullCalendar.Draggable;

    var calendarEl = document.getElementById('calendar');

    var id_servico = $("#id_servico").val();

    $.ajax({
        type: "post",
        url: BASE_URL+"Servico/get_dias_agendados/"+id_servico,
        dataType: "json",
        success: function(data)
        {
            var itens = [];
            $.each( data, function( key, value ) {
                var data_Split = value.data_servico.split('-')
                var hora_Split = value.hora_servico.split(':')
                var hora_final_Split = value.hora_final.split(':')
                
                var color = "";
                if(value.status_atual == "4")
                    color = '#f5b600';
                else
                    color = '#006400 ';

                var option = {
                    title: value.solicitante, 
                    start: new Date(data_Split[0], tira_zero(data_Split[1])-1, tira_zero(data_Split[2]), tira_zero(hora_Split[0]), tira_zero(hora_Split[1], 0)),
                    end: new Date(data_Split[0], tira_zero(data_Split[1])-1, tira_zero(data_Split[2]), tira_zero(hora_final_Split[0]), tira_zero(hora_final_Split[1], 0)),
                    allDay: false,
                    backgroundColor: color,
                    description: value.descricao,
                    url: BASE_URL+'Servico/movimentacao/'+value.id_orcamento,
                };

                itens.push(option);
            });

            var calendar = new Calendar(calendarEl, {
                headerToolbar: {
                    left  : 'prev,next today',
                    center: 'title',
                    right : 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                },
                initialView: 'timeGridWeek',
                contentHeight: "auto",
                locale: 'pt-br',
                themeSystem: 'bootstrap',
                events: itens,
                eventDidMount: function(info) {
                    if(info.event.extendedProps.description != '' && typeof info.event.extendedProps.description  !== "undefined")
                    {  
                        $(info.el).find(".fc-event-title").append("<br/><b>"+info.event.extendedProps.description+"</b>");
                    }
                },
            });

            if ($(window).width() < 514){
                calendar.changeView('listWeek');
            }

            calendar.render();
        }
    });

});

function tira_zero(valor)
{
    valor = valor.replace(/^0+/, '');
    if(valor == "")
        return 0;

    return valor;
}