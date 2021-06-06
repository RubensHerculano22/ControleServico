$(document).ready(function(){

    var id_orcamento = 0;

    $(".bloc_eye").on("click", function(){

        var classe = $(".bloc_eye")[0].lastElementChild.className;
        if(classe.search("fa-eye-slash") > -1)
        {
            $("#cpf").val("");
            $("#data_nascimento").val("");
            $(".icon_eyes").remove();
            $(".bloc_eye").html('<i class="fas fa-eye float-right icon_eyes"></i>');
        }
        else
        {
            cpf = $("#cpf_hidden").val();
            nascimento = $("#data_nascimento_hidden").val();
            $("#cpf").val(cpf);
            $("#data_nascimento").val(nascimento);
            $(".icon_eyes").remove();
            $(".bloc_eye").html('<i class="fas fa-eye-slash float-right icon_eyes"></i>');
        }
        
        // $(".icon_eyes").remove();
        // $(".bloc_eye").html("<i class=''");
    });

    $(".tabs").on("click", function(e){
        e.preventDefault();
        var id = $(this)[0].id;

        $.post(BASE_URL+"Usuario/troca_local/"+id, null, function(result){

        }, "json");

        $("#dados_tab").removeClass("show active");
        $("#favoritos_tab").removeClass("show active");
        $("#pedidos_tab").removeClass("show active");
        $("#cadastrado_tab").removeClass("show active");
        $("#suporte_tab").removeClass("show active");

        $("#"+id+"_tab").addClass("show active");
    });

    $(".orcamento_m").on("click", function(){
        id_orcamento = $(this).data("id");
    });

    $("#modal_orcamento").on("show.bs.modal", function(e){
        
        $.ajax({
            type: "post",
            url: BASE_URL+"Usuario/get_orcamentos/"+id_orcamento,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function(data)
            {
                $(".bloc_remove").remove();

                var html = "";
                var abre = 0;
                for(i=0;i<data.length;i++)
                {
                    $(".orcamentoResposta").addClass("d-none");
                    if(i%2==0)
                    {
                        abre = i;
                        html += '<tr class="bloc_remove">';
                        html += '<td style="border-right: 1px solid #000;" width="50%">';
                    }
                    else
                    {
                        html += '<td width="50%">';
                    }

                    html += '<div class="row mr-3 ml-3">';
                    
                    if(data[i].status.id == 1)
                    {

                        html += '<div class="col-md-6 col-sm-3 col-xs-12">'+
                                   '<div class="form-group">'+
                                        '<label for="nome">Data para o Serviço</label>'+
                                        '<input type="text" class="form-control" value="'+data[i].data_servico+'" readonly>'+
                                    '</div>'+
                                '</div>';
                        html += '<div class="col-md-6 col-sm-6 col-xs-12">'+
                                    '<div class="form-group">'+
                                        '<label for="nome">Hora para o Serviço</label>'+
                                        '<input type="text" class="form-control" value="'+data[i].hora_servico+'" readonly>'+
                                    '</div>'+
                                '</div>';
                        html += '<div class="col-md-12 col-sm-12 col-xs-12">'+
                                    '<div class="form-group">'+
                                        '<label for="nome">Descrição</label>'+
                                        '<textarea class="form-control" rows="3" readonly>'+data[i].descricao+'</textarea>'+
                                    '</div>'+
                                '</div>';
                        html += '<div class="col-md-12 col-sm-12 col-xs-12">'+
                                    '<div class="form-group">'+
                                        '<label for="nome">Endereço</label>'+
                                        '<input type="text" class="form-control" value="'+data[i].endereco+'" readonly>'+
                                    '</div>'+
                                '</div>';
                    }
                    else if(data[i].status.id == 2)
                    {
                        html += '<div class="col-md-4 col-sm-4 col-xs-12">'+
                                   '<div class="form-group">'+
                                        '<label for="nome">Status do Pedido</label>'+
                                        '<br/><i class="fas fa-chevron-right"></i> Orçamento Gerado'+
                                    '</div>'+
                                '</div>';
                        html += '<div class="col-md-8 col-sm-8 col-xs-12">'+
                                    '<div class="form-group">'+
                                        '<label for="nome">Orçamento</label>'+
                                        '<input type="text" class="form-control" value="'+data[i].orcamento+'" readonly>'+
                                    '</div>'+
                                '</div>';
                        html += '<div class="col-md-12 col-sm-12 col-xs-12">'+
                                    '<div class="form-group">'+
                                        '<label for="nome">Descrição</label>'+
                                        '<textarea class="form-control" rows="2" readonly>'+data[i].descricao+'</textarea>'+
                                    '</div>'+
                                '</div>';

                        $(".orcamentoResposta").removeClass("d-none");
                    }
                    else if(data[i].status.id == 3)
                    {
                        html += '<div class="col-md-12 col-sm-12 col-xs-12">'+
                                   '<div class="form-group">'+
                                        '<label for="nome">Status do Pedido</label>'+
                                        '<i class="fas fa-chevron-right"></i> Serviço Recusado'+
                                    '</div>'+
                                '</div>';
                        html += '<div class="col-md-12 col-sm-12 col-xs-12">'+
                                    '<div class="form-group">'+
                                        '<label for="nome">Descrição</label>'+
                                        '<textarea class="form-control" rows="2" readonly>'+(data[i].descricao != null ? data[i].descricao : "Sem descrição cadastrada")+'</textarea>'+
                                    '</div>'+
                                '</div>';
                    }
                    else if(data[i].status.id == 4)
                    {
                        html += '<div class="col-md-12 col-sm-12 col-xs-12 mt-4">'+
                                    '<div class="alert alert-warning  alert-dismissible">'+
                                        '<h5><i class="icon fas fa-check"></i> Confirmado</h5>'+
                                        'O Serviço foi aceito por ambas as partes, e será realizado no dia: '+data[0].data_servico+' horário: '+data[0].hora_servico +
                                    '</div>'
                                '</div>';
                    }
                    else if(data[i].status.id == 5)
                    {
                        var small = "";
                        var descriçao = "";

                        if(data[i+1] == null)
                        {
                            small = "(No aguardo de uma nova resposta do Prestador)";
                        }
                        if(data[i].descricao != null)
                            descricao = '<textarea class="form-control" rows="2" readonly>'+(data[i].descricao != null ? data[i].descricao : "Sem descrição cadastrada")+'</textarea>';

                        html += '<div class="col-md-12 col-sm-12 col-xs-12 mt-4">' +
                                    '<div class="form-group">' +
                                        '<label for="nome">Status do Pedido</label>' +
                                        '<br/><i class="fas fa-chevron-right"></i> O cliente recusou o orçamento gerado.' +
                                        '<small>'+small+'</small>'+
                                        descricao +
                                    '</div>'+
                                '</div>';
                    }
                    else if(data[i].status.id == 6)
                    {
                        html += '<div class="col-md-12 col-sm-12 col-xs-12 mt-4">'+
                                    '<div class="alert alert-danger alert-dismissible">'+
                                        '<h5><i class="icon fas fa-exclamation-circle"></i>Serviço Cancelado</h5>'+
                                        'O serviço foi cancelado por: '+data[i].usuario.nome+', na data: '+data[i].data_alteracao +
                                    '</div>'
                                '</div>';

                        $(".orcamentoResposta").addClass("d-none");
                    }
                    else if(data[i].status.id == 7)
                    {
                        html += '<div class="col-md-12 col-sm-12 col-xs-12">'+
                                    '<div class="alert alert-success  alert-dismissible">'+
                                        '<h5><i class="icon fas fa-check"></i> Concluido</h5>'+
                                        'O Serviço foi concluido na data: (colocar data)'+
                                    '</div>'
                                '</div>';
                    }


                    html += '</div>';
                    html += '</td>';

                    if(i == abre + 2)
                    {
                        html += '</tr>';
                    }
                }
                
                $("#id_orcamento").val(id_orcamento);
                $("#bloco_orcamento").append(html);
            }
        });
    });

    $("#submit").submit(function(e){
        e.preventDefault();
        var data = $(this).serialize();
        data = new FormData($("#submit").get(0));

        $.ajax({
            type: "post",
            url: BASE_URL+"Usuario/resposta_orcamento",
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
                    
                    $("#modal_orcamento").modal("hide");
                }
                else if(data.rst === false)
                {
                    showNotification("warning", data.msg, "Tente novamente daqui a alguns minutos", "toast-top-center");
                }
            }
        });
    });

    $(".cancela_servico").on("click", function(e){
        e.preventDefault();
        var id = $(this).data("id");
        Swal.fire({
            title: 'Aviso',
            text: "Deseja realmente cancelar esse serviço?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: `Sim`,
            cancelButtonText: `Não`,
            }).then((result) => {
            if (result.isConfirmed)
            {
                $.ajax({
                    type: "post",
                    url: BASE_URL+"Usuario/cancela_servico/"+id,
                    dataType: "json",
                    success: function(data)
                    {
                        if(data === true)
                        {
                            Swal.fire({
                                icon: 'success',
                                title: 'Sucesso',
                                text: "Serviço cancelado com sucesso!"
                            }).then((result) => {
                                window.location.href = BASE_URL+"Usuario/perfil/pedidos";
                            });
                        }
                        else if(data.rst === false)
                        {
                            showNotification("warning", "Erro ao tentar cancelar o serviço", "Tente novamente daqui a alguns minutos", "toast-top-center");
                        }
                    }
                });
            }
        });
    });
});