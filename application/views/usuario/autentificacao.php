<div class="container">
    <div class="row justify-content-md-center justify-content-md-center">
        <div class="col-md-auto">
            <div class="card card-outline card-info">
                <div class="card-header text-center">
                    <a href="<?= base_url("Servico") ?>" class="h1" onMouseOver="this.style.color='#17a2b8'" onMouseOut="this.style.color='#212529'">NexToYou</a>
                </div>
                <div class="card-body">
                    <p class="login-box-msg">Autentifique-se para melhorar sua navegação &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
                    <form id="submit">
                        <div class="input-group mb-3">
                            <input type="email" id="email" name="email" class="form-control" placeholder="Email" autofocus>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" id="senha" name="senha" class="form-control" placeholder="Senha">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row p-4">
                            <div class="col-12">
                                <button type="submit" class="btn btn-info btn-block">Entrar</button>
                            </div>
                        </div>
                    </form>
                    <p class="mb-1">
                        <a href="<?= base_url("Usuario/esqueci_senha") ?>" style="color: #17a2b8">Esqueci a senha</a>
                    </p>
                    <p class="mb-0">
                        <a href="<?= base_url("Usuario") ?>" class="text-center" style="color: #17a2b8">Não possui cadastro ainda? Realize agora!</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>