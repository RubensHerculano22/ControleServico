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

        var html = '<li class="list-group-item">'+ pagamento + " - " + vezes + " " + juro + '</li>';
        $("#lista_pagamento").append(html);
    })

    $("#adicionar_horario").on("click", function(e){
        e.preventDefault();

        $("#lista_de_horario").removeClass("d-none");

        var id_dia_semana = $("#dia_semana").val();
        var dia_semana = document.getElementById("dia_semana")[id_dia_semana - 1].innerText;
        var horario_inicio = $("#horario_inicio").val();
        var horario_fim = $("#horario_fim").val();

        var html = '<li class="list-group-item">'+ dia_semana + " / " + horario_inicio + " - " + horario_fim + '</li>';
        $("#lista_horario").append(html);
    });
});
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