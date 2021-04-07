$(document).ready(function(){

    $(".tabs").on("click", function(e){
        e.preventDefault();
        var id = $(this)[0].id;

        $("#dados_tab").removeClass("show active");
        $("#favoritos_tab").removeClass("show active");
        $("#pedidos_tab").removeClass("show active");
        $("#cadastrado_tab").removeClass("show active");
        $("#suporte_tab").removeClass("show active");

        $("#"+id+"_tab").addClass("show active");
    })

});