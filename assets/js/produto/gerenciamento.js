$(document).ready(function(){
    var id = $("#id_servico").val();
    atualiza_perguntas(id);

    $("input[data-bootstrap-switch]").each(function(){
        $(this).bootstrapSwitch('state', $(this).prop('checked'));
    });

    $("#submit_pergunta").submit(function(e){
        e.preventDefault();
        var data = $(this).serialize();
        data = new FormData($("#submit").get(0));

        $.ajax({
            type: "post",
            url: BASE_URL+"Servico/responder_pergunta",
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            data: data,
            success: function(data)
            {
                console.log(data);
                if(data.rst === true)
                {
                    Swal.fire({
                        icon: 'success',
                        title: 'Sucesso',
                        text: 'Pedido de contratação enviado para o Prestador, você será notificado quando houver retorno'
                    });
                    $("#modal_contratacao").modal("hide");
                }
                else if(data.rst === false)
                {
                    showNotification("warning", "Erro ao pedir contratação ", data.msg, "toast-top-center");
                }
            }
        });
    });
});

function abrirResposta(id)
{
    var pergunta = $("#pergunta"+id)[0].innerHTML;
    $("#id_pergunta").val(id);
    $("#pergunta_input").val(pergunta);
    $("#modal_resposta").modal("show");
}

function atualiza_perguntas(id)
{

}