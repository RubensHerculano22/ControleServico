$(document).ready(function(){

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

        $("#dados_tab").removeClass("show active");
        $("#favoritos_tab").removeClass("show active");
        $("#pedidos_tab").removeClass("show active");
        $("#cadastrado_tab").removeClass("show active");
        $("#suporte_tab").removeClass("show active");

        $("#"+id+"_tab").addClass("show active");
    })

});