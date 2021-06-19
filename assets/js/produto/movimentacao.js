$(document).ready(function(){

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

    $("#submit").submit(function(e){
        e.preventDefault();
        var data = $(this).serialize();
        data = new FormData($("#submit").get(0));

        $.ajax({
            type: "post",
            url: BASE_URL+"Servico/resposta_orcamento",
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
                        text: data.msg
                    });

                    Swal.fire({
                        icon: 'success',
                        title: 'Sucesso',
                        text: data.msg
                    }).then((result) => {
                        window.location.reload();
                    });
                    
                }
                else if(data.rst === false)
                {
                    showNotification("warning", data.msg, "Tente novamente daqui a alguns minutos", "toast-top-center");
                }
            }
        });
    });

    $(".finalizado").on("click", function(){
        var id = $("#id_orcamento").val();

        Swal.fire({
            title: 'Aviso',
            text: "Definir este serviço como realizado?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: `Sim`,
            cancelButtonText: `Não`,
            }).then((result) => {
            if (result.isConfirmed)
            {
                $.ajax({
                    type: "post",
                    url: BASE_URL+"Servico/servico_realizado/"+id,
                    dataType: "json",
                    success: function(data)
                    {
                        if(data.rst === true)
                        {
                            Swal.fire({
                                icon: 'success',
                                title: 'Sucesso',
                                text: data.msg
                            }).then((result) => {
                                window.location.reload();
                            });
                        }
                        else if(data.rst === false)
                        {
                            showNotification("warning", data.msg, "Tente novamente daqui a alguns minutos", "toast-top-center");
                        }
                    }
                });
            }
        });
    });
});