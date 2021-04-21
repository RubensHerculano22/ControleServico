$(document).ready(function(){
    var id = $("#id_servico").val();
    atualiza_perguntas(id);

    $("input[data-bootstrap-switch]").each(function(){
        $(this).bootstrapSwitch('state', $(this).prop('checked'));
    });

    $("#ver_lista").on("click", function(e){
        e.preventDefault();
        if($(".lcp_bloc").hasClass('d-none'))
        {
            atualiza_perguntas(id, true);
            $(".lcp_bloc").removeClass("d-none");
        }
        else
        {
            $(".lcp_bloc").addClass("d-none");
        }
            
    })

    $("#submit_pergunta").submit(function(e){
        e.preventDefault();
        var data = $(this).serialize();
        data = new FormData($("#submit_pergunta").get(0));

        $.ajax({
            type: "post",
            url: BASE_URL+"Servico/responder_pergunta",
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            data: data,
            success: function(data)
            {
                if(data.rst === true)
                {
                    Swal.fire({
                        icon: 'success',
                        title: 'Sucesso',
                        text: data.msg
                    });
                    atualiza_perguntas(id)
                    atualiza_perguntas(id, true)
                    $("#modal_resposta").modal("hide");
                }
                else if(data.rst === false)
                {
                    showNotification("warning", data.msg, "Tente novamente daqui a alguns minutos", "toast-top-center");
                }
            }
        });
    });

    $("#modal_resposta").on("hide.bs.modal", function(e){
        $("#resposta").val("");
    });
});

function abrirResposta(id)
{
    var pergunta = $("#pergunta"+id)[0].innerHTML;
    var resposta = $("#resposta"+id);
    console.log(resposta.length)
    $("#id_pergunta").val(id);
    $("#pergunta_input").val(pergunta);
    if(resposta.length > 0)
        $("#resposta").val(resposta[0].innerHTML);
    $("#modal_resposta").modal("show");
}

function atualiza_perguntas(id, resposta = false)
{
    $.ajax({
        type: "post",
        url: BASE_URL+"Servico/get_perguntas/"+id+"/"+resposta,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(data)
        {
            if(resposta == true)
            {
                $(".lista_pergunta_completa").remove();

                if(data.length > 0)
                {
                    $.each( data, function( key, value ) {
                        var html = '<div class="col-md-12 col-sm-12 col-xs-12 lista_pergunta_completa">' +
                                        '<div class="callout callout-info">' +
                                            '<div class="row">' +
                                                '<div class="col-md-10 col-sm-12 col-xs-12">' +
                                                    '<p id="pergunta'+value.id+'">'+value.pergunta+'</p>' +
                                                    (value.resposta != null ? '<small id="resposta'+value.id+'">'+value.resposta+'</small>' : '')  +
                                                    '<small class="float-right">'+value.data_inclusao_br+'</small>' +
                                                '</div>' +
                                                '<div class="col-md-2 col-sm-12 col-xs-12 align-self-center text-center">' +
                                                    '<button type="button" class="btn btn-info mr-4" onclick="abrirResposta('+value.id+')">'+(value.resposta != null ? 'Editar Resposta' : 'Responder')+'</button>' +
                                                '</div>' +
                                            '</div>' +
                                        '</div>' +
                                    '</div>';    
                        
                        $("#lcp").append(html);
                    });
                }
                else
                {
                    var html = '<div class="col-md-12 col-sm-12 col-xs-12 lista_pergunta">' +
                                '<div class="callout callout-info">' +
                                    '<p>Este Serviço ainda não possui perguntas.</p>' +
                                '</div>' +
                            '</div>';
                            
                    $("#lcp").append(html);
                }
                
            }
            else
            {
                $(".lista_pergunta").remove();

                if(data.length > 0)
                {
                    $.each( data, function( key, value ) {
                        var html = '<div class="col-md-12 col-sm-12 col-xs-12 lista_pergunta">' +
                                        '<div class="callout callout-info">' +
                                            '<div class="row">' +
                                                '<div class="col-md-10 col-sm-12 col-xs-12">' +
                                                    '<p id="pergunta'+value.id+'">'+value.pergunta+'</p>' +
                                                    '<small class="float-right">'+value.data_inclusao_br+'</small>' +
                                                '</div>' +
                                                '<div class="col-md-2 col-sm-12 col-xs-12 align-self-center text-center">' +
                                                    '<button type="button" class="btn btn-info mr-4" onclick="abrirResposta('+value.id+')">Responder</button>' +
                                                '</div>' +
                                            '</div>' +
                                        '</div>' +
                                    '</div>';    

                        $("#lista_pergunta").append(html);
                    });
                }
                else
                {
                    var html = '<div class="col-md-12 col-sm-12 col-xs-12 lista_pergunta">' +
                                '<div class="callout callout-info">' +
                                    '<p>Este Serviço ainda não possui perguntas pedentes.</p>' +
                                '</div>' +
                            '</div>';
                            
                    $("#lista_pergunta").append(html);
                }
            }
        }
    });
}