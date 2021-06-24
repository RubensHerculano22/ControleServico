<div class="container">
    <div class="row justify-content-md-center justify-content-md-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center" style="background-color: <?= $colores->color2 ?>">
                    <p class="h3" style="color: <?= $colores->color5 ?>;">Definição de nova senha</p>
                </div>
                <div class="card-body">
                    <form id="submit">
                        <div class="input-group mb-3">
                            <input type="text" id="codigo" name="codigo" class="form-control" placeholder="Codigo" autofocus>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-pen"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row d-none" id="troca_senha">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="celular">Senha</label><small>(Necessário no minimo conter 8 digitos e no minimo 1 numero)</small>
                                    <input type="password" class="form-control" name="senha" id="senha" placeholder="Senha">
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="celular">Confirmação de Senha</label>
                                    <input type="password" class="form-control" name="conf_senha" id="conf_senha" placeholder="Confirmação de senha">
                                </div>
                            </div>
                        </div>
                        <input type="hidden" value="" id="id_usuario" name="id_usuario"/>
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