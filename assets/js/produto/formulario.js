var cont = 0;

$(document).ready(function(){

    $(".tipo_servico").on("change", function(){
        var valor = $("input[name=tipo]")[1];
        if(valor.checked == true)
            $("#aluguel_equipamentos").removeClass("d-none");
        else
            $("#aluguel_equipamentos").addClass("d-none");
    });

    $("#categoria_principal").on("change", function(){
        var valor = $("#categoria_principal").val();
        
        $.post(BASE_URL+"servico/get_subcategorias", {categoria: valor}, function(result){
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
    
    $("#adicionar_meio_pagamento").on("click", function(e){
        e.preventDefault();

        $("#lista_pag").removeClass("d-none");

        var id_pagamento = $("#pagamento").val();
        var pagamento = document.getElementById("pagamento")[id_pagamento - 1].innerText;

        var vezes = $("#vezes").val();
        vezes = (vezes != "1") ? vezes + "x" : "À vista";
        
        var juros1 = document.getElementById("juros1");
        var juros2 = document.getElementById("juros2");
        var juro = "";
        if(juros1.checked == true)
            juro = "Com Juros";
        else if(juros2.checked == true)
            juro = "Sem Juros";

        var html = '<li class="list-group-item" id="li_meio_'+cont+'">'+ pagamento + " - " + vezes + " " + juro + '<span class="float-right"><button class="btn btn-danger" type="button" onclick="exclui_meio_pagamento(\'li_meio_'+cont+'\')"><i class="fas fa-times"></i></button></span></li>';
        $("#lista_pagamento").append(html);
        cont++;
    })

    $("#adicionar_horario").on("click", function(e){
        e.preventDefault();

        $("#lista_de_horario").removeClass("d-none");

        var id_dia_semana = $("#dia_semana").val();
        var dia_semana = document.getElementById("dia_semana")[id_dia_semana - 1].innerText;
        var horario_inicio = $("#horario_inicio").val();
        var horario_fim = $("#horario_fim").val();
        
        var html = '<li class="list-group-item" id="li_horario_'+cont+'">'+ dia_semana + " / " + horario_inicio + " - " + horario_fim + '<span class="float-right"><button class="btn btn-danger" type="button" onclick="exclui_horario(\'li_horario_'+cont+'\')"><i class="fas fa-times"></i></button></span></li>';
        $("#lista_horario").append(html);
        cont++;
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
                                text: data.msg,
                                icon: 'success',
                                confirmButtonText: `Ok`,
                                }).then((result) => {
                                if (result.isConfirmed)
                                    window.location.href = BASE_URL+"Produto/jogo/"+data.id_jogo;
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

/**
 * <optgroup label="Swedish Cars">
        <option>option 1</option>
        <option>option 2</option>
    </optgroup>
    <optgroup label="Swedish Cars">
        <option>option 3</option>
        <option>option 4</option>
        <option>option 5</option>
    </optgroup>
 */


    /**
     * como vem o post: Request.Form["search"];
     * $("#cmb_pasta_destino").select2({
            ajax: {
                url: "/processo/pasta_lista",
                method: "POST",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        search: params.term, // search term
                    };
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            },
            placeholder: 'Digite o nome da pasta',
            escapeMarkup: function (markup) { return markup; },
            minimumInputLength: 3,
            templateResult: formatRepo,
            templateSelection: formatRepoSelection,
            language: "pt-BR"
        });

        Retorna da função 

         var str = new
        {
            id = pasta.RowId,
            text = caminho + " / " + pasta.titulo

        };

        em list.

     * function formatRepo(repo) {
        if (repo.loading) {
            return repo.text;
        }
        console.log(repo);
        var $container = $(
            "<div class='select2-result-repository clearfix'>" +
            "<div class='select2-result-repository__meta'>" +
            "<div class='select2-result-repository__title'>" + repo.text + "</div>" +
            "</div>" +
            "</div>"
        );

        return $container;
    }

    function formatRepoSelection(repo) {
        return repo.full_name || repo.text;
    }
     * 
     * 
     */