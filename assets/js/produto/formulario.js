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
            console.log(result)
        });
    });
});