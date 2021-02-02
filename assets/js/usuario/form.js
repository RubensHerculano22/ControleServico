$(document).ready(function(){

    const regex = /[0-9]/

    $('.select2').select2()

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
        senha = $("#senha").val();
        id_usuario = $("#id_usuario").val();
        c_senha = $("#confirmacao_senha").val();
        if((id_usuario == "" || senha != "") && senha.length < 8)
        {
            showNotification("error", "Erro ao cadastrar", "A senha necessita conter no minimo 8 caracteres", "toast-top-center");
        }
        else if((id_usuario == "" || senha != "") && !regex.test(senha))
        {
            showNotification("error", "Erro ao cadastrar", "A senha precisa ter ao menos 1 numero.", "toast-top-center");
        }
        else if(senha != c_senha)
        {
            showNotification("error", "Erro ao cadastrar", "As senhas não coincidem", "toast-top-center");
        }
        else
        {
            $.ajax({
                type: "post",
                url: BASE_URL+"Usuario/salva_usuario",
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
                                window.location.href = BASE_URL+"Usuario/login";
                        })
                    }
                    else if(data.rst === 2)
                    {
                        Swal.fire({
                            title: 'Erro',
                            text: data.msg,
                            icon: 'info',
                            confirmButtonText: `Ok`,
                            }).then((result) => {
                            if (result.isConfirmed)
                                window.location.href = BASE_URL+"Usuario/login";
                        })
                    }
                    else if(data.rst === 0)
                    {
                        showNotification("warning", "Erro ao cadastrar", data.msg, "toast-top-center");
                    }
                    else if(data.rst === 4)
                    {
                        showNotification("success", "Sucesso", data.msg, "toast-top-center");
                    }
                }
            });
        }   
    });

});