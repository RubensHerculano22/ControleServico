$(document).ready(function(){
    var id = $("#id_servico").val();
    atualiza_perguntas(id);

    $("input[data-bootstrap-switch]").each(function(){
        $(this).bootstrapSwitch('state', $(this).prop('checked'));
    });

    // var tableMensagem = $("#lista_mensagem").DataTable({
    //     language: {
    //         url: BASE_URL+"assets/plugins/datatables/portugues-brasil.json",
    //         select: { rows: { _: "%d linhas selecionadas", 1: "1 linha selecionada", 0: "" } }
    //     },
    //     ajax: {
    //         url: BASE_URL+"Servico/get_mensangens/"+id,
    //         dataSrc: "",
    //         type: "post",
    //         dataType: "json",
    //         data: function(d){
    //             return post;
    //         },
    //     },
    //     order: [[5, "asc"],[4,"desc"],[3, "desc"]],
    //     columns: [
    //         {data: "id_tipo_movimentacao.nome", title: "Tipo de Movimentação"},
    //         {data: "id_emitente.nome", title: "Emitente"},
    //         {data: "status.nome", title: "Status"},
    //         {data: "data_movimentacao", title: "Data de Solicitação"},
    //         {data: "data_modificacao", title: "Ultima Modificação"},
    //         {
    //             data: null,
    //             title: "Opções",
    //             render: function(data, x, row){

    //                 var edita = '<a href="<?= base_url("Movimentacao/") ?>'+row.tipo_movimentacao+'/'+row.id+'" class="btn bg-amber waves-effect"><p class="hide">1</p><i class="material-icons">edit</i></a>';
    //                 var exibe = '<a href="<?= base_url("Movimentacao/exibeMovimentacao") ?>'+'/'+row.id+'" class="btn bg-indigo waves-effect"><p class="hide">3</p><i class="material-icons">info</i></a>';
    //                 var exibe_finalizada = '<a href="<?= base_url("Movimentacao/exibeMovimentacao") ?>'+'/'+row.id+'" class="btn bg-green waves-effect"><p class="hide">2</p><i class="material-icons">check</i></a>';
    //                 var responder = '<a href="<?= base_url("Movimentacao/exibeMovimentacao") ?>'+'/'+row.id+'" class="btn bg-red waves-effect"><p class="hide">1</p><i class="material-icons">create</i></a>';
    //                 if(row.depart.id_departamento === '13' || row.depart.id_departamento === '35')
    //                 {
    //                     if(row.id_empregado == '<?= $dados->user_id ?>')
    //                     {
    //                         if(row.status.id == '4')
    //                             return edita;
    //                         else if(row.status.id == '9')
    //                             return exibe_finalizada;
    //                         else
    //                             return exibe;
    //                     }
    //                     else
    //                     {
    //                         if(row.status.id == '2' || row.status.id == '4')
    //                             return responder;
    //                         else if(row.status.id == '9')
    //                             return exibe_finalizada;
    //                         else
    //                             return exibe;
    //                     }
    //                 }
    //                 else if(row.depart.id_departamento === '28')
    //                 {
    //                     if(row.status.id == '3')
    //                         return responder;
    //                     else
    //                         return exibe
    //                 }
    //                 else if(row.id_empregado == '<?= $dados->user_id ?>')
    //                 {
    //                     if(row.status.id == '5' || row.status.id == '6' || row.status.id == '12')
    //                         return edita;
    //                     else if(row.status.id == '1' || row.status.id == '7' || row.status.id == '8')
    //                         return exibe;
    //                     else
    //                         return exibe;
    //                 }
    //                 else if(row.status.id == '11')
    //                 {
    //                     if(row.p_logado === '434' || row.p_logado === '300')
    //                         return responder;
    //                     else
    //                         return exibe;
    //                 }
    //                 else if(row.id_supervisor == '<?= $dados->user_id ?>')
    //                 {
    //                     if(row.status.id == '1')
    //                         return responder;
    //                     else
    //                         return exibe;
    //                 }
    //                 else
    //                     return exibe;
    //             }
    //         }
    //     ],
    //     "columnDefs": [
    //         {"type": 'date-uk', "targets": [3, 4]},
    //         {"className": "text-center", "targets": "_all"},
    //     ],
    // });

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