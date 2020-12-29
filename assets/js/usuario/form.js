$(document).ready(function(){

    $('#cpf').inputmask({
        mask: ['999.999.999-99'],
        keepStatic: true
    });
    $('#telefone').inputmask({
        mask: ['(99) 9999-9999'],
        keepStatic: true
    });
    $('#celular').inputmask({
        mask: ['(99) 99999-9999'],
        keepStatic: true
    });
    $('#numero').inputmask({
        mask: ['[9][9][9]9'],
        keepStatic: true
    });
    $('[data-mask]').inputmask();


    $("#submit").submit(function(e){
        e.preventDefault();
        var data = $(this).serialize();
        data = new FormData($("#submit").get(0));

        // if(email != "")
        // {
        //     if(senha != "")
        //     {
                $.ajax({
                    type: "post",
                    url: BASE_URL+"Usuario/autentifica",
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    data: data,
                    success: function(data)
                    {
                        if(data.rst === true)
                        {
                            window.location.href = BASE_URL+"Home";
                        }
                        else if(data.rst === false)
                        {
                            showNotification("warning", "Erro ao cadastrar", data.error, "toast-top-center");
                        }
                    }
                });
        //     }
        //     else
        //     {
        //         showNotification("warning", "Erro no campo", "Campo 'Senha' está vazio", "toast-top-center");
        //     }
        // }
        // else
        // {
        //     showNotification("warning", "Erro no campo", "Campo 'Email' está vazio", "toast-top-center");
        // }
    });

});