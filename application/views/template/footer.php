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
<script src="<?= base_url("assets/plugins/jqvmap/maps/jquery.vmap.usa.js") ?>"></script>
<!-- jQuery Knob Chart -->
<script src="<?= base_url("assets/plugins/jquery-knob/jquery.knob.min.js") ?>"></script>
<!-- daterangepicker -->
<script src="<?= base_url("assets/plugins/moment/moment.min.js") ?>"></script>
<script src="<?= base_url("assets/plugins/daterangepicker/daterangepicker.js") ?>"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?= base_url("assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js") ?>"></script>
<!-- Summernote -->
<script src="<?= base_url("assets/plugins/summernote/summernote-bs4.min.js") ?>"></script>
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
<!-- AdminLTE App -->
<script src="<?= base_url("assets/plugins/dist/js/adminlte.js") ?>"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?= base_url("assets/plugins/dist/js/demo.js") ?>"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?= base_url("assets/plugins/dist/js/pages/dashboard.js") ?>"></script>

<script type="text/javascript">
    var BASE_URL = "<?= base_url() ?>";
    var LOGGED = "<?= isset($dados) && $dados->logged == true ? 1 : 0 ?>";

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
              url: BASE_URL+"Home/favoritar/",
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

</script>