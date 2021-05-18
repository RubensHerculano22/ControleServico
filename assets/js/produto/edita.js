var meio_pagamento = $("#quantidade_meio_pagamento").val();
var horario = $("#quantidade_horario").val();
$(document).ready(function(){
    $('#summernote').summernote();

    $('[data-mask]').inputmask();

    $(".preco").inputmask('decimal', {
        'alias': 'numeric',
        'groupSeparator': ',',
        'autoGroup': true,
        'digits': 2,
        'radixPoint': ".",
        'digitsOptional': false,
        'allowMinus': false,
        'prefix': 'R$ ',
    });

    $("#estado").val($("#id_estado").val()).trigger('change');
    $("#cidade").val($("#id_cidade").val()).trigger('change');

    $(".tipo_servico").on("change", function(){
        var valor = $("input[name=tipo_servico]")[1];
        console.log(valor.checked);
        if(valor.checked == true)
            $(".aluguel_equipamento").removeClass("d-none");
        else
            $(".aluguel_equipamento").addClass("d-none");
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

        var html = '<li class="list-group-item list_group_pagamento" id="li_meio_'+meio_pagamento+'" data-id="'+id_pagamento+'/'+vezes_ini+'/'+juros+'">'+ pagamento + " - " + vezes + " " + juro + '<span class="float-right"><button class="btn btn-danger" type="button" onclick="exclui_meio_pagamento(\'li_meio_'+meio_pagamento+'\')"><i class="fas fa-times"></i></button></span></li>';
        $("#lista_pagamento").append(html);
        meio_pagamento++;
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

            var html = '<li class="list-group-item list_group_horario" id="li_horario_'+horario+'" data-id="'+id_dia_semana+'/'+horario_inicio+'/'+horario_fim+'">'+ dia_semana + " / " + horario_inicio + " - " + horario_fim + '<span class="float-right"><button class="btn btn-danger" type="button" onclick="exclui_horario(\'li_horario_'+horario+'\')"><i class="fas fa-times"></i></button></span></li>';
            $("#lista_horario").append(html);
            horario++;
        }
        else
            showNotification("error", "Erro ao tentar adicionar o horario na lista", "Um horario não foi inserido.", "toast-top-center", "15000");
    });
});

function exclui_meio_pagamento(id){$("#"+id).remove()}