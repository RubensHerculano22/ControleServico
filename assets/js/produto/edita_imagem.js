
$(document).ready(function(){

    $("input[data-bootstrap-switch]").bootstrapSwitch();

    $('input[name="principal_switch"]').on('switchChange.bootstrapSwitch', function (event, state) {
        var data = {"ativo": state, "id_imagem": $(this).data("imagem"), "id_servico": $("#id_servico").val()};

        Swal.fire({
            title: 'Aviso',
            text: "Deseja realmente definir está imagem como principal?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: `Sim`,
            cancelButtonText: `Não`,
            }).then((result) => {
            if (result.isConfirmed && state == true)
            {
                $.post(BASE_URL+"Servico/troca_principal", data, function(data) {
                    if(data.rst == true)
                    {
                        Swal.fire({
                            title: 'Sucesso',
                            text: data.msg,
                            icon: 'success',
                            confirmButtonText: `Ok`,
                            }).then((result) => {
                            if (result.isConfirmed)
                            {
                                window.location.reload();
                            }
                                
                        });
                    }
                    else
                    {
                        Swal.fire({
                            title: data.msg,
                            text: "Ocorreu um problema ao definir a imagem como principal.",
                            icon: 'warning',
                            confirmButtonText: `Ok`,
                            }).then((result) => {
                            if (result.isConfirmed)
                            {
                                window.location.reload();
                            }
                                
                        });
                    }
                }, "json");
            }
            else
            {
                if(state == false)
                {
                    Swal.fire({
                        title: 'Não é possivel realizar essa operação',
                        text: "Caso queira trocar a imagem principal, apenas troque na imagem que seja definir",
                        icon: 'warning',
                        confirmButtonText: `Ok`,
                        }).then((result) => {
                        if (result.isConfirmed)
                        {
                            window.location.reload();
                        }
                            
                    });
                }
                else
                    window.location.reload();
            }
                
        })
    });

    $('input[name="ativo_switch"]').on('switchChange.bootstrapSwitch', function (event, state) {
        var data = {"ativo": state, "id_imagem": $(this).data("imagem")};

        var text = "";
        if(state == true)
            text = "ativo";
        else
            text = "desativado";

        Swal.fire({
            title: 'Aviso',
            text: "Deseja realmente definir está imagem como "+text+"?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: `Sim`,
            cancelButtonText: `Não`,
            }).then((result) => {
            if (result.isConfirmed)
            {
                $.post(BASE_URL+"Servico/troca_ativo", data, function(data) {
                    if(data.rst == true)
                    {
                        Swal.fire({
                            title: 'Sucesso',
                            text: data.msg,
                            icon: 'success',
                            confirmButtonText: `Ok`,
                            }).then((result) => {
                            if (result.isConfirmed)
                            {
                                window.location.reload();
                            }
                                
                        });
                    }
                    else
                    {
                        Swal.fire({
                            title: "Ops...",
                            text: data.msg,
                            icon: 'warning',
                            confirmButtonText: `Ok`,
                            }).then((result) => {
                            if (result.isConfirmed)
                            {
                                window.location.reload();
                            }
                                
                        });
                    }
                }, "json");
            }
            else
            {
                window.location.reload();
            }
                
        })
    });

    $("#submit").submit(function(e){
        e.preventDefault(); 
        var data = $(this).serialize();
        data = new FormData($("#submit").get(0));
        $.ajax({
            type: "post",
            url: BASE_URL+"Servico/insere_imagem",
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            data: data,
            success: function(data)
            {
                if(data.rst == true)
                {
                    Swal.fire({
                        title: 'Sucesso',
                        text: data.msg,
                        icon: 'success',
                        confirmButtonText: `Ok`,
                        }).then((result) => {
                        if (result.isConfirmed)
                        {
                            $("#id_imagem").val("");
                            $(".principal_input").removeClass("d-none");
                            $("#titulo_modal").html("Cadastrar uma nova Imagem");
                            window.location.reload();
                        }
                            
                    });
                }
                else
                {
                    showNotification("error", data.msg, "Ocorreu um problema ao realizar a inserção da imagem.", "toast-top-center", "15000");
                }
            }
        });
    });

    $("#modalImagem").on("hide.bs.modal", function(){
        $("#id_imagem").val("");
        $(".principal_input").removeClass("d-none");
        $("#titulo_modal").html("Cadastrar uma nova Imagem");
    });
});

function editaImagem(id)
{
    $(".principal_input").addClass("d-none");
    $("#titulo_modal").html("Editar Imagem");
    $("#id_imagem").val(id);

    $("#modalImagem").modal("show");
}

function removeImagem(id)
{
    var data = {"id_imagem":id};

    Swal.fire({
        title: 'Aviso',
        text: "Deseja realmente excluir essa imagem permanentemente?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: `Sim`,
        cancelButtonText: `Não`,
        }).then((result) => {
        if (result.isConfirmed)
        {
            $.post(BASE_URL+"Servico/exclui_imagem", data, function(data) {
                console.log(data)
                if(data.rst == true)
                {
                    Swal.fire({
                        title: 'Sucesso',
                        text: data.msg,
                        icon: 'success',
                        confirmButtonText: `Ok`,
                        }).then((result) => {
                        if (result.isConfirmed)
                        {
                            window.location.reload();
                        }
                            
                    });
                }
                else
                {
                    showNotification("error", data.msg, data.subtexto, "toast-top-center", "15000");
                }
            }, "json");
        }
            
    })
}