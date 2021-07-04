$(document).ready(function(){

    $("#submit").submit(function(e){
        e.preventDefault();

        var titulo = $("#titulo").val();
        var avaliacao = $("input[name=avaliacao]");

        var verifC = 0;
        for(i=0;i<avaliacao.length;i++)
        {
            if(avaliacao[i].checked == true)
            {
                verifC = 1;
            }
        }

        if(titulo == "")
        {
            showNotification("error", "Erro no cadastro do feedback", "O campo 'Titulo' precisa ser preenchido", "toast-top-center");
        }
        else if(verifC == 0)
        {
            showNotification("error", "Erro no cadastro do feedback", "O campo 'Avaliação' precisa ser preenchido", "toast-top-center");
        }
        else
        {
            var data = $(this).serialize();
            data = new FormData($("#submit").get(0));
    
            Swal.fire({
                title: 'Aguarde enquanto processamos a requisição',
                showConfirmButton: false,
                allowOutsideClick: false,
                onBeforeOpen: () => {
                    Swal.showLoading()
                },
            });

            $.ajax({
                type: "post",
                url: BASE_URL+"Feedback/cadastra_feedback",
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json",
                data: data,
                success: function(data)
                {
                    swal.close();
                    if(data.rst === true)
                    {
                        Swal.fire({
                            title: 'Sucesso',
                            text: data.msg,
                            icon: 'success',
                            confirmButtonText: `Ok`,
                            }).then((result) => {
                            if (result.isConfirmed)
                                window.location.href = BASE_URL+"Servico";
                        })
                    }
                    else if(data.rst === false)
                    {
                        showNotification("error", "Erro", data.msg, "toast-top-center", "15000");
                    }
                }
            });
        }
        
    })

});