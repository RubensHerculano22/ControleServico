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
                if(value.status == "4")
                    color = '#fca000';
                else
                    color = '#28a745 ';

                var option = {
                    title: value.solicitante, 
                    start: new Date(data_Split[0], tira_zero(data_Split[1])-1, tira_zero(data_Split[2]), tira_zero(hora_Split[0]), tira_zero(hora_Split[1], 0)),
                    end: new Date(data_Split[0], tira_zero(data_Split[1])-1, tira_zero(data_Split[2]), tira_zero(hora_final_Split[0]), tira_zero(hora_final_Split[1], 0)),
                    allDay: false,
                    backgroundColor: color,
                    // description: '<b>Descrição: </b>'+value.descricao
                };

                itens.push(option);
            });

            var calendar = new Calendar(calendarEl, {
                headerToolbar: {
                    left  : 'prev,next today',
                    center: 'title',
                    right : 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                initialView: 'timeGridWeek',
                contentHeight: "auto",
                views: {
                    timeGridFourDay: {
                      type: 'timeGrid',
                      duration: { days: 4 }
                    }
                },
                locale: 'pt-br',
                themeSystem: 'bootstrap',
                events: itens,
                //Random default events
                // events: [
                // {
                //     title          : 'Click for Google',
                //     start          : new Date(y, m, 28),
                //     end            : new Date(y, m, 29),
                //     url            : 'https://www.google.com/',
                //     backgroundColor: '#3c8dbc', //Primary (light-blue)
                //     borderColor    : '#3c8dbc' //Primary (light-blue)
                // }
                // ],
            });

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