var lista_endereco = [];

$(document).ready(function(){

    var cont = 0;

    const regex = /[0-9]/

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

    $('body').scrollspy({ target: '#modal_termos' })

    $(".endereco_input").on("change", function(){
        var cep     = $("#cep").val();
        var estado  = $("#estado").val();
        var numero  = $("#numero").val();

        if(cep != "" && numero != "" && estado != "")
        {
            $("#add_endereco").attr("disabled", false);
        }
        else
        {
            $("#add_endereco").attr("disabled", true);
        }
    });

    $("#data_nascimento").on("change", function(){
        var data = $("#data_nascimento").val();
        if(verifData(data) == false)
        {
            showNotification("error", "Erro no cadastrar", "Campo data com data invalida, uma data de maior de idade deve ser inserida", "toast-top-center");
            $("#salva").attr("disabled", true);
        }
        else
        {
            id_usuario = $("#id_usuario").val();
            cpf = $("#cpf").val();
            if((id_usuario != "" || $(".linha_tabela")[0].childElementCount > 0) && TestaCPF(cpf) == true)
            {
                $("#salva").attr("disabled", false);
            }
            else
            {
                $("#salva").attr("disabled", true);
            }
        }
    });

    $("#add_endereco").on("click", function(){
        var cep = $("#cep").val();
        var estado = $("#estado").val();
        var cidade = $("#cidade").val();
        var bairro = $("#bairro").val();
        var endereco = $("#endereco").val();
        var numero = $("#numero").val();
        var complemento = $("#complemento").val();

        var item = {"id": cont,"cep": cep, "estado": estado, "cidade": cidade, "bairro": bairro, "endereco": endereco, "numero": numero, "complemento": complemento};
        lista_endereco.push(item);
        $("#lista_endereco").removeClass("d-none");

        var html =  "<tr id='linha"+cont+"'>"+
                        "<td>"+cep+" ( "+ endereco+", "+(complemento != "" ? numero+" "+complemento : numero)+" "+bairro+" - "+cidade+", "+estado+" )" +"</td>"+
                        "<td class='text-center'><button type='button' class='btn btn-danger' onclick='remove_endereco("+cont+")'><i class='fas fa-minus-circle'></i></button></td>"+
                    "</tr>";

        $(".linha_tabela").append(html);
        var string = "";
        for(i=0;i<lista_endereco.length;i++)
        {
            if(i>0)
                string += " - ";
            string += JSON.stringify(lista_endereco[i]);
        }

        data = $("#data_nascimento").val();
        if(TestaCPF($("#cpf").val()) == false || verifData(data) == false)
        {
            $("#salva").attr("disabled", true)
        }
        else
        {
            $("#salva").attr("disabled", false)
        }

        $("#enderecos").val(string);
        cont++;
    })

    $("#submit").submit(function(e){
        e.preventDefault();
        
        var data = $(this).serialize();
        data = new FormData($("#submit").get(0));
        
        senha = $("#senha").val();
        id_usuario = $("#id_usuario").val();
        c_senha = $("#confirmacao_senha").val();
        cpf = $("#cpf").val();
        if((id_usuario == "" || senha != "") && senha.length < 8)
        {
            showNotification("error", "Erro no cadastrar", "A senha necessita conter no minimo 8 caracteres", "toast-top-center");
        }
        else if((id_usuario == "" || senha != "") && !regex.test(senha))
        {
            showNotification("error", "Erro no cadastrar", "A senha precisa ter ao menos 1 numero.", "toast-top-center");
        }
        else if(senha != c_senha)
        {
            showNotification("error", "Erro no cadastrar", "As senhas não coincidem", "toast-top-center");
        }
        else if(id_usuario == "" && $(".linha_tabela")[0].childElementCount <= 0)
        {
            showNotification("error", "Erro no cadastrar", "É necessário cadastrar pelo menos 1 endereço", "toast-top-center");
        }
        else if(TestaCPF(cpf) == false)
        {
            showNotification("error", "Erro no cadastrar", "Campo cpf com dado invalido", "toast-top-center");
        }
        else
        {
            if(id_usuario == "")
            {
                Swal.fire({
                    title: 'Aguarde enquanto processamos a requisição',
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    onBeforeOpen: () => {
                        Swal.showLoading()
                    },
                });
            }
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
                        swal.close();
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
                    else if(data.rst === 0)
                    {
                        showNotification("warning", "Erro ao cadastrar", data.msg, "toast-top-center");
                    }
                    else if(data.rst === 4)
                    {
                        Swal.fire({
                            title: "Sucesso",
                            text: data.msg,
                            icon: "success",
                            confirmButtonText: `Ok`,
                            }).then((result) => {
                            if (result.isConfirmed)
                                window.location.reload();
                        })
                    }
                }
            });
        }   
    });

    $("#cpf").on("change", function(){
        var verif = true;
        id_usuario = $("#id_usuario").val();
        if($("#cpf").val() != "")
            verif = TestaCPF($("#cpf").val());

        if(verif == false)
        {
            $("#salva").attr("disabled", true);
            showNotification("error", "Erro", "CPF digitado é invalido", "toast-top-center");
        }
        else
        {
            data = $("#data_nascimento").val();
            if((id_usuario != "" || ($(".linha_tabela")[0].childElementCount > 0)) && verifData(data) == true)
            {
                $("#salva").attr("disabled", false);
            }
            else
            {
                $("#salva").attr("disabled", true);
            }
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
                        console.log(data);
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

function remove_endereco(id)
{
    var string = "";

    for(i=0;i<lista_endereco.length;i++)
    {
        if(lista_endereco[i].id == id)
        {
            lista_endereco.splice(i, 1);
        }
        else
        {
            if(i>0)
                string += " - ";
            string += JSON.stringify(lista_endereco[i]);
        }
    }
    
    $("#enderecos").val(string);

    $("#linha"+id).remove();

    if($(".linha_tabela")[0].childElementCount <= 0)
    {
        $("#lista_endereco").addClass("d-none");
        $("#salva").attr("disabled", true)
    }

}

function TestaCPF(strCPF) {
    var Soma;
    var Resto;
    Soma = 0;
    strCPF = strCPF.replace(/[^\d]+/g,'');
    if (strCPF == "00000000000") return false;

    for (i=1; i<=9; i++) Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (11 - i);
    Resto = (Soma * 10) % 11;

    if ((Resto == 10) || (Resto == 11))  Resto = 0;
    if (Resto != parseInt(strCPF.substring(9, 10)) ) return false;

    Soma = 0;
    for (i = 1; i <= 10; i++) Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (12 - i);
    Resto = (Soma * 10) % 11;

    if ((Resto == 10) || (Resto == 11))  Resto = 0;
    if (Resto != parseInt(strCPF.substring(10, 11) ) ) return false;

    return true;
}

function verifData(data)
{
    if(data == "") return false;
    dataSplit = data.split("/");

    d = new Date()

    ano = d.getFullYear()-18;
    mes = d.getMonth()+1;
    if (mes < 10) { mes = '0' + mes; }
    dia = d.getDate();

    if(((ano - dataSplit[2])) <= 0)
    {
        if((dataSplit[2] - ano) == 0)
        {
            if(dataSplit[1] == mes && dataSplit[0] > dia)
            {
                return false;
            }
            else if(dataSplit[1] > mes)
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }

    return true;
}