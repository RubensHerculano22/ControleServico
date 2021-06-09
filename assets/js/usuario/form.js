$(document).ready(function(){

    var lista_endereco = [];

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
    $('#cep').inputmask({
        mask: ['99999-999'],
        keepStatic: true
    });
    $('[data-mask]').inputmask();

    $("#add_endereco").on("click", function(){
        var cep = $("#cep").val();
        var estado = $("#estado").val();
        var cidade = $("#cidade").val();
        var bairro = $("#bairro").val();
        var endereco = $("#endereco").val();
        var numero = $("#numero").val();
        var complemento = $("#complemento").val();

        if(cep == null)
        {
            showNotification("error", "Erro no campo CEP", "Nenhum valor foi adicionado ao campo cep.", "toast-top-center");
        }

        if(estado == null || cidade == null || bairro == null || endereco == null)
        {
            showNotification("error", "Erro!", "Nenhum valor valido foi inserido no cep.", "toast-top-center");
        }

        if(numero == null)
        {
            showNotification("error", "Erro!", "Nenhum valor valido foi inserido no campo Numero.", "toast-top-center");
        }

        var item = {"cep": cep, "estado": estado, "cidade": cidade, "bairro": bairro, "endereco": endereco, "numero": numero, "complemento": complemento};
        lista_endereco.push(item);
    })

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
    }
    else
    {
        showNotification("error", "Erro no campo CEP", "Valores invalidos foram cadastrados no campo CEP.", "toast-top-center");
    }
}