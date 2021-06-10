$(document).ready(function(){

    $('#cep').inputmask({
        mask: ['99999-999'],
        keepStatic: true
    });

    $("#submit").submit(function(e){
        e.preventDefault();
        
        var data = $(this).serialize();
        data = new FormData($("#submit").get(0));
        $.ajax({
            type: "post",
            url: BASE_URL+"Usuario/salva_endereco",
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            data: data,
            success: function(data)
            {
                if(data.rst === 1)
                {
                    Swal.fire({
                        title: 'Sucesso',
                        text: data.msg,
                        icon: 'success',
                        confirmButtonText: `Ok`,
                        }).then((result) => {
                        if (result.isConfirmed)
                            window.location.href = BASE_URL+"Usuario/perfil/dados";
                    })
                }
                else if(data.rst === 0)
                {
                    showNotification("warning", "Erro", data.msg, "toast-top-center");
                }
            }
        });
    });

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
                    $("#endereco").val(data.logradouro)
                    $("#bairro").val(data.bairro)
                    $("#cidade").val(data.localidade)
                    $("#estado").val(data.estado.nome)
                }

                $(".bloc_pesquisa").replaceWith('<div class="bloc_pesquisa"><br/><button type="button" onclick="pesquisa_cep()" class="btn mt-2" style="background-color: #254B59; color: #F0F2F0"><i class="fas fa-search-location"></i> Pesquisar</button></div>');
            }, "json");

        }, 1000);

        $("#salva").attr("disabled", false);
    }
    else
    {
        showNotification("error", "Erro no campo CEP", "Valores invalidos foram cadastrados no campo CEP.", "toast-top-center");
        $("#salva").attr("disabled", true);
    }
}