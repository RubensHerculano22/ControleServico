<!-- jQuery -->
<script src="<?= base_url("assets/plugins/jquery/jquery.min.js") ?>"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?= base_url("assets/plugins/jquery-ui/jquery-ui.min.js") ?>"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="<?= base_url("assets/plugins/bootstrap/js/bootstrap.bundle.min.js") ?>"></script>
<!-- ChartJS -->
<script src="<?= base_url("assets/plugins/chart.js/Chart.min.js") ?>"></script>
<!-- Sparkline -->
<script src="<?= base_url("assets/plugins/sparklines/sparkline.js") ?>"></script>
<!-- JQVMap -->
<script src="<?= base_url("assets/plugins/jqvmap/jquery.vmap.min.js") ?>"></script>
<script src="<?= base_url("assets/plugins/jqvmap/maps/jquery.vmap.brazil.js") ?>"></script>
<!-- jQuery Knob Chart -->
<script src="<?= base_url("assets/plugins/jquery-knob/jquery.knob.min.js") ?>"></script>
<!-- daterangepicker -->
<script src="<?= base_url("assets/plugins/moment/moment.min.js") ?>"></script>
<script src="<?= base_url("assets/plugins/daterangepicker/daterangepicker.js") ?>"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?= base_url("assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js") ?>"></script>
<!-- Summernote -->
<script src="<?= base_url("assets/plugins/summernote/summernote-bs4.min.js") ?>"></script>
<!-- CodeMirror -->
<script src="<?= base_url("assets/plugins/codemirror/codemirror.js")?>"></script>
<script src="<?= base_url("assets/plugins/codemirror/mode/css/css.js")?>"></script>
<script src="<?= base_url("assets/plugins/codemirror/mode/xml/xml.js")?>"></script>
<script src="<?= base_url("assets/plugins/codemirror/mode/htmlmixed/htmlmixed.js")?>"></script>
<!-- Ekko lightbox -->
<script src="<?= base_url("assets/plugins/ekko-lightbox/ekko-lightbox.min.js") ?>"></script>
<!-- overlayScrollbars -->
<script src="<?= base_url("assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js") ?>"></script>
<!-- sweetalert2 -->
<script src="<?= base_url("assets/plugins/sweetalert2/sweetalert2.min.js") ?>"></script>
<!-- toastr -->
<script src="<?= base_url("assets/plugins/toastr/toastr.min.js") ?>"></script>
<!-- InputMask -->
<script src="<?= base_url("assets/plugins/inputmask/jquery.inputmask.min.js") ?>"></script>
<!-- Select2 -->
<script src="<?= base_url("assets/plugins/select2/js/select2.full.min.js") ?>"></script>
<!-- Bootstrap Switch -->
<script src="<?= base_url("assets/plugins/bootstrap-switch/js/bootstrap-switch.min.js")?>"></script>
<!-- BS-Stepper -->
<script src="<?= base_url("assets/plugins/bs-stepper/js/bs-stepper.min.js") ?>"></script>
<!-- dropzonejs -->
<script src="<?= base_url("assets/plugins/dropzone/min/dropzone.min.js") ?>"></script>
<!-- AdminLTE App -->
<script src="<?= base_url("assets/plugins/dist/js/adminlte.js") ?>"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?= base_url("assets/plugins/dist/js/demo.js") ?>"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?= base_url("assets/plugins/dist/js/pages/dashboard.js") ?>"></script>
<!-- bs-custom-file-input -->
<script src="<?= base_url("assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js") ?>"></script>
<!-- DataTables  & Plugins -->
<script src="<?= base_url("assets/plugins/datatables/jquery.dataTables.min.js") ?>"></script>
<script src="<?= base_url("assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js") ?>"></script>
<script src="<?= base_url("assets/plugins/datatables-responsive/js/dataTables.responsive.min.js") ?>"></script>
<script src="<?= base_url("assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js") ?>"></script>

<script type="text/javascript">
    var BASE_URL = "<?= base_url() ?>";
    var LOGGED = "<?= isset($dados) && $dados->logged == true ? 1 : 0 ?>";

    $(document).ready(function(){
        $(".select2").select2();

        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });

        $("#button_search_bar").on("click", function(e){
            e.preventDefault();
            var pesquisa = $("#input_search_bar").val();
            window.location.href = BASE_URL+"Servico/pesquisa/"+pesquisa;
        })

        var modal_aberto = "<?= (!empty($cidade) ? 1 : 0) ?>";
        if(modal_aberto == 0)
        {
            $("#modalLocalizacao").modal("show");
        }

        $("#modalLocalizacao").on("show.bs.modal", function(){
            var estado = $("#estado_atual").val();
            if(estado)
            {
                $(".option_atual").remove();
                $.ajax({
                    type: "post",
                    url: BASE_URL+"Servico/get_cidades/"+estado,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    success: function(data)
                    {
                        if(data != null)
                        {
                            var cidade = "<?= $cidade && $cidade->id_cidade ? $cidade->id_cidade : "" ?>"
                            var html = '';
                            for(i=0;i<data.length;i++)
                            {
                                html += '<option class="option_atual" value="'+data[i].ID+'" '+(cidade == data[i].ID ? "selected" : "")+'>'+data[i].Nome+'</option>';
                            }

                            $("#cidade_atual").append(html);
                            $("#cidade_atual").trigger('change');
                        }
                        else
                        {
                            showNotification("error", "Cidades não encontradas", "Não há nenhuma cidade cadastrada para este estado.", "toast-top-center", "15000");
                        }
                    }
                });
            }
        });

        $("#estado_atual").on("change", function(){
            var estado = $("#estado_atual").val();
            $(".option_atual").remove();
            $.ajax({
                type: "post",
                url: BASE_URL+"Servico/get_cidades/"+estado,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(data)
                {
                    if(data != null)
                    {
                        var html = '';
                        for(i=0;i<data.length;i++)
                        {
                            html += '<option class="option_atual" value="'+data[i].ID+'">'+data[i].Nome+'</option>';
                        }

                        $("#cidade_atual").append(html);
                        $("#cidade_atual").trigger('change');
                    }
                    else
                    {
                        showNotification("error", "Cidades não encontradas", "Não há nenhuma cidade cadastrada para este estado.", "toast-top-center", "15000");
                    }
                }
            });
        });

        $("#troca_cidade").on("click", function(){
            var estado = $("#estado_atual").val();
            var cidade = $("#cidade_atual").val();
            
            $.ajax({
                type: "post",
                url: BASE_URL+"Servico/troca_cidade/"+estado+"/"+cidade,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(data)
                {
                    if(data == true)
                    {
                        window.location.reload();
                    }
                    else
                    {
                        showNotification("error", "Um erro aconteceu!", "Não foi possivel realizar a troca da cidade.", "toast-top-center", "15000");
                    }
                }
            });
        });
    });

    function showNotification(colorName, title, text, positionClass) {
      if (colorName === null || colorName === '') { colorName = 'info'; }
      if (text === null || text === '') { text = 'Deixe sua mensagem aqui'; }
      if (title === null || title === '') { title = 'Titulo'; }
      if (positionClass === null || positionClass === '') { positionClass = 'toast-top-center'; }

      toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": positionClass,
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "500",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
      }

      Command: toastr[colorName](text, title)
    }

    function favoritos(id, tipo)
    {
        if(LOGGED == 0)
        {
            Swal.fire({
                title: 'Aviso',
                text: "Para adicionar ao favoritos é necessário estar autentificado. Deseja ir para a pagina de Autentificação?",
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: `Sim`,
                cancelButtonText: `Não`,
                }).then((result) => {
                if (result.isConfirmed)
                {
                    window.location.href = BASE_URL+"Usuario/login";
                }
                    
            })
        }
        else
        {
          var data = {"id_servico": id, "tipo": tipo};
          $.ajax({
              type: "post",
              url: BASE_URL+"Servico/favorita_servico/",
              dataType: "json",
              data:  data,
              success: function(data)
              {
                  if(data.rst === 1)
                  {
                      var html = '<i class="fas fa-heart float-right" onclick="favoritos('+id+', \'preenchido\')" data-tipo="preenchido" style="color: red" id="item'+id+'"></i>';
                      $("#item"+id).remove();
                      $("#fav"+id).append(html);
                      showNotification("success", "Salvo", "Serviço adicionado ao favoritos", "toast-top-center");
                  }
                  else if(data.rst === 2)
                  {
                      var html = '<i class="far fa-heart float-right" onclick="favoritos('+id+', \'vazio\')" data-tipo="vazio" style="color: grey" id="item'+id+'"></i>';
                      $("#item"+id).remove();
                      $("#fav"+id).append(html);
                      showNotification("success", "Salvo", "Serviço removido dos favoritos", "toast-top-center");
                  }
                  else if(data.rst === 0)
                  {
                      showNotification("error", "Problema ao salvar no favoritos", "Tente novamente mais tarde", "toast-top-center");
                  }
              }
          });
        }
    }

    function isValidDate(date)
    {
        var matches = /^(\d{2})[-\/](\d{2})[-\/](\d{4})$/.exec(date);
        if (matches == null) return false;
        var d = matches[2];
        var m = matches[1] - 1;
        var y = matches[3];
        var composedDate = new Date(y, m, d);
        return composedDate.getDate() == d &&
                composedDate.getMonth() == m &&
                composedDate.getFullYear() == y;
    }

</script>