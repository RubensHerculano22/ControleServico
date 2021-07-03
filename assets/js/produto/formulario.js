var cont = 0;

$(document).ready(function(){

    $('#cep').inputmask({
        mask: ['99999-999'],
        keepStatic: true
    });

    $(".tipo_servico").on("change", function(){
        var valor = $("input[name=tipo_servico]")[1];
        if(valor.checked == true)
            $(".aluguel_equipamentos").removeClass("d-none");
        else
            $(".aluguel_equipamentos").addClass("d-none");
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
        {
            $(".area_servico").addClass("d-none")
            $(".local_especifico").removeClass("d-none");
        }
        else
        {
            $(".local_especifico").addClass("d-none")
            $(".area_servico").removeClass("d-none");

            $("#cep").val("");
            $("#estado_input").val("");
            $("#cidade_input").val("");
            $("#bairro_input").val("");
            $("#endereco_input").val("");
            $("#numero_input").val("");
            $("#complemento_input").val("");
        }
    });
    
    $("#adicionar_meio_pagamento").on("click", function(e){
        e.preventDefault();

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

        var verif = 0;
        if(id_pagamento == "")
        {
            showNotification("error", "Erro", "Nenhum tipo de pagamento selecionado", "toast-top-center", "15000");
        }
        else
        {
            if(vezes_ini == "")
            {
                showNotification("error", "Erro", "Nenhum quantidade de vezes foi selecionado", "toast-top-center", "15000");
            }
            else
            {
                if(juros1.checked == false && juros2.checked == false)
                {
                    showNotification("error", "Erro", "Nenhum tipo de juros foi selecionado", "toast-top-center", "15000");
                }
                else
                {
                    verif = 1;
                }
            }
        }

        if(verif == 1)
        {
            $("#lista_pag").removeClass("d-none");

            var html = '<li class="list-group-item list_group_pagamento" id="li_meio_'+cont+'" data-id="'+id_pagamento+'/'+vezes_ini+'/'+juros+'">'+ pagamento + " - " + vezes + " " + juro + '<span class="float-right"><button class="btn btn-danger" type="button" onclick="exclui_meio_pagamento(\'li_meio_'+cont+'\')"><i class="fas fa-times"></i></button></span></li>';
            $("#lista_pagamento").append(html);
            cont++;
        }
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
        var empty = 1;
        if(files.length > 0)
        {
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
        }
        else
        {
            empty = 0;
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
        console.log(erro)
        if(erro != "" || empty == 0)
        {
            showNotification("error", "Erro", (erro != "" ? "Tipo do arquivo não permitido. Por favor troque os seguintes arquivos:"+erro : "Nenhuma imagem foi inserida"), "toast-top-center", "15000");
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
                                    window.location.href = BASE_URL+"Servico/gerenciar_servico/"+data.id;
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

    $(".proximo").on("click", function(){
        var id = $(this).data("id");
        if(id == 1)
        {
            var verif = 0;
            if($("#nome").val() != "")
            {
                if($("#descricao_curta").val() != "")
                {
                    if($("#categoria_principal").val() > 0)
                    {
                        if($("#categoria_especifica").val() > 0)
                        {
                            if($("input[name=tipo_servico]")[1].checked == true || $("input[name=tipo_servico]")[0].checked == true)
                            {
                                if($("#lista_pagamento")[0].childElementCount > 0)
                                {
                                    if($("#local_servico")[0].checked == true)
                                    {
                                        if($("#estado_input").val() != "")   
                                        {
                                            verif = 1;
                                        }
                                        else
                                        {
                                            showNotification("error", "Erro", "O campo 'CEP' deve ser preenchido", "toast-top-center", "15000");
                                        }
                                    }
                                    else
                                    {
                                        if($("#estado").val() != "")
                                        {
                                            verif = 1;
                                        }
                                        else
                                        {
                                            showNotification("error", "Erro", "O campo 'Estado' deve ser preenchido'", "toast-top-center", "15000");
                                        }
                                    }
                                }
                                else
                                {
                                    showNotification("error", "Erro", "Nenhuma forma de pagamento foi cadastrada", "toast-top-center", "15000");
                                }
                            }
                            else
                            {
                                showNotification("error", "Erro", "O campo 'Tipo de Serviço' deve ser preenchido", "toast-top-center", "15000");
                            }
                        }
                        else
                        {
                            showNotification("error", "Erro", "O campo 'Categoria Especifica' deve ser preenchido", "toast-top-center", "15000");
                        }
                    }
                    else
                    {
                        showNotification("error", "Erro", "O campo 'Categoria Principal' deve ser preenchido", "toast-top-center", "15000");
                    }
                }
                else
                {
                    showNotification("error", "Erro", "O campo 'Descrição curta' deve ser preenchido", "toast-top-center", "15000");    
                }
            }
            else
            {
                showNotification("error", "Erro", "O campo 'nome' deve ser preenchido", "toast-top-center", "15000");
            }

            if(verif == 1)
            {
                nextForm();
            }
        }
        else if(id == 2)
        {
            var verif = 0;
            if($("#summernote").length <= 0)
            {
                showNotification("error", "Erro", "O campo 'Descrição completa' deve ser preenchido", "toast-top-center", "15000");
            }
            else
            {
                verif = 1;
            }

            if(verif == 1)
            {
                nextForm();
            }
        }
        else if(id == 3)
        {
            var verif = 0;
            if($("#lista_horario")[0].childElementCount > 0)
            {
                verif = 1;
            }
            else
            {
                showNotification("error", "Erro", "Nenhuma horario de atendimento foi cadastrada", "toast-top-center", "15000");
            }

            if(verif == 1)
            {
                nextForm();
            }
        }
        
    })
});

function pesquisa_cep()
{
    var cep = $("#cep").val();
    if(cep.length > 8)
    {
            $(".bloc_pesquisa").replaceWith('<div class="bloc_pesquisa"><br/><button type="button" class="btn mt-2" style="background-color: #254B59; color: #F0F2F0"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>&nbsp;Carregando</button></div>');
            setTimeout(() => {        
                
                cep_tratado = cep.split("").filter(n => (Number(n) || n == 0)).join("");

                var data = {"cep": cep_tratado};
                $.post(BASE_URL+"Servico/get_cep", data, function(data) {
                    if(data.estado == null)
                    {
                        showNotification("error", "Erro no campo CEP", "Valores invalidos foram cadastrados no campo CEP.", "toast-top-center");                
                    }
                    else
                    {
                        $("#endereco_input").val(data.logradouro)
                        $("#bairro_input").val(data.bairro)
                        $("#cidade_input").val(data.localidade)
                        $("#estado_input").val(data.estado.nome)
                    }

                    $(".bloc_pesquisa").replaceWith('<div class="bloc_pesquisa"><br/><button type="button" onclick="pesquisa_cep()" class="btn mt-2" style="background-color: #254B59; color: #F0F2F0"><i class="fas fa-search-location"></i> Pesquisar</button></div>');
                }, "json");

            }, 1000);
    }
    else
    {
        showNotification("error", "Erro no campo CEP", "Valores invalidos foram cadastrados no campo CEP.", "toast-top-center");
    }
}

function exclui_meio_pagamento(id){
    $("#"+id).remove()
    if($("#lista_pagamento")[0].childElementCount <= 0)
    {
        $("#lista_pag").addClass("d-none");
    }
}

function exclui_horario(id){
    $("#"+id).remove()
    if($("#lista_horario")[0].childElementCount <= 0)
    {
        $("#lista_de_horario").addClass("d-none");
    }
}