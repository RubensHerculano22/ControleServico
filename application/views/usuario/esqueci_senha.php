<div class="container">
    <div class="row justify-content-md-center justify-content-md-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center" style="background-color: <?= $colores->color2 ?>">
                    <p class="h3" style="color: <?= $colores->color5 ?>;">Esqueci a senha</p>
                </div>
                <div class="card-body">
                    <form id="submit">
                        <div class="input-group mb-3">
                            <input type="email" id="email" name="email" class="form-control" placeholder="Email" autofocus>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row p-4">
                            <div class="col-md-6">
                                <a href="<?= base_url("Usuario/login") ?>" class="btn float-left" style="background-color: <?= $colores->color2 ?>"><span style="color: <?= $colores->color5 ?>">Voltar</span></a>
                            </div>
                            <div class="col-md-6">
                                <button type="submit" class="btn float-right" style="background-color: <?= $colores->color2 ?>"><span style="color: <?= $colores->color5 ?>">Enviar</span></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>