$(document).ready(function(){

    $(".tipo_servico").on("change", function(){
        var valor = $("input[name=tipo]")[1];
        if(valor.checked == true)
            $("#aluguel_equipamentos").removeClass("d-none");
        else
            $("#aluguel_equipamentos").addClass("d-none");
    });
});