var cont = 0;

$(document).ready(function(){

    $(".tipo_servico").on("change", function(){
        var valor = $("input[name=tipo_servico]")[1];
        if(valor.checked == true)
            $("#aluguel_equipamentos").removeClass("d-none");
        else
            $("#aluguel_equipamentos").addClass("d-none");
    });

    $("#categoria_principal").on("change", function(){
        var valor = $("#categoria_principal").val();
        
        $(".categoria_especifica").removeClass("d-none");

        $.post(BASE_URL+"servico/get_subcategorias/"+valor, null, function(result){
            $(".optremove").remove();
            var html = "";
            result = JSON.parse(result);
            $.each(result, function( key, value ) {
                
                html += "<optgroup label='"+value.nome+"' classe='optremove'>";
                $.each( value.filhos, function( i, item ) {
                    html += "<option value='"+item.id+"'>"+item.nome+"</option>";
                });
                html += "</optgroup>";
            });

            $("#categoria_especifica").html(html);
        });
    });

    $("#estado").on("change", function(){
        var estado = $("#estado").val();
        $(".option_cidades").remove();
        $.ajax({
            type: "post",
            url: BASE_URL+"Servico/get_cidades/"+estado,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function(data)
            {
                if(data != null)
                {
                    var html = '';
                    for(i=0;i<data.length;i++)
                    {
                        html += '<option class="option_cidades" value="'+data[i].ID+'">'+data[i].Nome+'</option>';
                    }

                    $("#cidade").append(html);
                    $("#cidade").trigger('change');
                }
                else
                {
                    showNotification("error", "Cidades não encontradas", "Não há nenhuma cidade cadastrada para este estado.", "toast-top-center", "15000");
                }
            }
        });
    });

    $("#local_servico").on("click", function(){
        var valor = $("input[name=local]")[0];
        if(valor.checked == true)
            $("#endereco_input").removeClass("d-none");
        else
        {
            $("#endereco").val("");
            $("#endereco_input").addClass("d-none");
        }
    });
    
    $("#adicionar_meio_pagamento").on("click", function(e){
        e.preventDefault();

        $("#lista_pag").removeClass("d-none");

        var id_pagamento = $("#pagamento").val();
        var pagamento = document.getElementById("pagamento")[id_pagamento - 1].innerText;

        var vezes_ini = $("#vezes").val();
        vezes = (vezes_ini != "1") ? vezes_ini + "x" : "À vista";
        
        var juros1 = document.getElementById("juros1");
        var juros2 = document.getElementById("juros2");
        var juro = "";
        if(juros1.checked == true)
        {
            juro = "Com Juros";
            juros = 1;
        }
        else if(juros2.checked == true)
        {
            juro = "Sem Juros";
            juros = 0;
        }

        var html = '<li class="list-group-item list_group_pagamento" id="li_meio_'+cont+'" data-id="'+id_pagamento+'/'+vezes_ini+'/'+juros+'">'+ pagamento + " - " + vezes + " " + juro + '<span class="float-right"><button class="btn btn-danger" type="button" onclick="exclui_meio_pagamento(\'li_meio_'+cont+'\')"><i class="fas fa-times"></i></button></span></li>';
        $("#lista_pagamento").append(html);
        cont++;
    })

    $("#adicionar_horario").on("click", function(e){
        e.preventDefault();

        var id_dia_semana = $("#dia_semana").val();
        var dia_semana = document.getElementById("dia_semana")[id_dia_semana - 1].innerText;
        var horario_inicio = $("#horario_inicio").val();
        var horario_fim = $("#horario_fim").val();

        if(horario_inicio != "" && horario_fim != "")
        {
            $("#lista_de_horario").removeClass("d-none");

            var html = '<li class="list-group-item list_group_horario" id="li_horario_'+cont+'" data-id="'+id_dia_semana+'/'+horario_inicio+'/'+horario_fim+'">'+ dia_semana + " / " + horario_inicio + " - " + horario_fim + '<span class="float-right"><button class="btn btn-danger" type="button" onclick="exclui_horario(\'li_horario_'+cont+'\')"><i class="fas fa-times"></i></button></span></li>';
            $("#lista_horario").append(html);
            cont++;
        }
        else
            showNotification("error", "Erro ao tentar adicionar o horario na lista", "Um horario não foi inserido.", "toast-top-center", "15000");
    });

    $("#submit").submit(function(e){
        e.preventDefault();
        var data = $(this).serialize();
        files = myDropzone.files;
        
        var erro = "";
        for(i=0;i<files.length;i++)
        {
            tipo = files[i].name.split(".").pop().toLowerCase();
            if(jQuery.inArray(tipo, ['gif','png','jpg','jpeg']) == -1)
            {
                if(erro != "")
                    erro += ", ";
                
                erro += files[i].name + "";
            }
        }

        lista_pagamento = [];
        $('.list_group_pagamento').each(function () {
            lista_pagamento.push($(this).data('id'));
        });
        
        $("#lista_pagamento_input").val(lista_pagamento.toString());


        lista_horario = [];
        $('.list_group_horario').each(function () {
            lista_horario.push($(this).data('id'));
        });

        $("#lista_horario_input").val(lista_horario.toString());

        if(erro)
        {
            showNotification("error", "Erro nas imagens cadastradas", "Tipo do arquivo não permitido. Por favor troque os seguintes arquivos: "+ erro, "toast-top-center", "15000");
        }
        else
        {
            myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED));
            data = new FormData($("#submit").get(0));
            setTimeout(() => { 

                $.ajax({
                    type: "post",
                    url: BASE_URL+"Servico/cadastro_servico",
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
                                title: 'Sucesso',
                                text: "Serviço inserido com sucesso",
                                icon: 'success',
                                confirmButtonText: `Ok`,
                                }).then((result) => {
                                if (result.isConfirmed)
                                    window.location.href = BASE_URL+"Servico/gerenciar_servico/"+data.id_servico;
                            })
                        }
                        else if(data.rst === false)
                        {
                            showNotification("warning", "Erro", data.msg, "toast-top-center", "15000");
                        }
                    }
                });

            }, 2000);
        }
    })
});

function exclui_meio_pagamento(id){$("#"+id).remove()}

function exclui_horario(id){$("#"+id).remove()}