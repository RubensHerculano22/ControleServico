<div class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 pt-5">
            <div class="card">
                <div class="card-header" style="background-color: <?= $colores->color2 ?>">
                    <h3 class="card-title" style="color: <?= $colores->color5 ?>""><?= $usuario == false ? "Formulário de Cadastro de Novos Usuarios" : "Formulário de Edição de Informações de  Usuarios" ?></h3>
                </div>
                <form id="submit" role="form">
                    <div class="card-body">
                        <div class="row">
                            <small class="text-danger">* Obrigatorios</small><br/>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="nome">Nome</label><small class="text-danger"> *</small>
                                    <input type="text" class="form-control" name="nome" id="nome" value="<?= set_value('nome', @$usuario->nome); ?>" placeholder="Nome" required autofocus>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="sobrenome">Sobrenome</label><small class="text-danger"> *</small>
                                    <input type="text" class="form-control" name="sobrenome" value="<?= set_value('sobrenome', @$usuario->sobrenome); ?>" id="Sobrenome" placeholder="Sobrenome" required>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-12">
                                <div class="form-group">
                                    <label for="cpf">CPF</label><small class="text-danger"> *</small>
                                    <input type="text" class="form-control" name="cpf" id="cpf" value="<?= set_value('cpf', @$usuario->cpf); ?>" placeholder="CPF: xxx-xxx-xxx-xx" required>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-12">
                                <div class="form-group">
                                    <label for="data_nascimento">Data de Nascimento</label><small class="text-danger"> *</small>
                                    <input type="text" class="form-control" name="data_nascimento" id="data_nascimento" value="<?= set_value('data_nascimento', @$usuario->data_nascimento); ?>" placeholder="Exemplo: 01/01/2004" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask required>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-12">
                                <div class="form-group">
                                    <label for="telefone">Telefone</label>
                                    <input type="text" class="form-control" name="telefone" id="telefone" value="<?= set_value('telefone', @$usuario->telefone); ?>" placeholder="Exemplo: (11) 1111-1111">
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-12">
                                <div class="form-group">
                                    <label for="celular">Celular</label>
                                    <input type="text" class="form-control" name="celular" id="celular" value="<?= set_value('celular', @$usuario->celular); ?>" placeholder="Exemplo: (11) 11111-1111">
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <hr>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="email">Email</label><small class="text-danger"> *</small>
                                    <input type="email" class="form-control" name="email" value="<?= set_value('email', @$usuario->email); ?>" id="email" placeholder="exemplo@exemplo.com.br" required>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="senha">Senha</label> <?php if(!isset($usuario->id)): ?><small class="text-danger"> *</small> <?php endif; ?><small>(Necessário no minimo conter 8 digitos e no minimo 1 numero)</small>
                                    <input type="password" class="form-control" name="senha" id="senha" placeholder="Senha" <?php if(!isset($usuario->id)): ?> required <?php endif; ?>>
                                    <?php if(isset($usuario->id)): ?><small>(Caso não deseje trocar a senha apenas deixe em branco)</small><?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="confirmacao_senha">Confirmação de Senha</label> <?php if(!isset($usuario->id)): ?><small class="text-danger"> *</small> <?php endif; ?>
                                    <input type="password" class="form-control" name="confirmacao_senha" id="confirmacao_senha" placeholder="Confirmação de Senha" <?php if(!isset($usuario->id)): ?> required <?php endif; ?>>
                                </div>
                            </div>
                            <?php if($usuario == null): ?>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <hr>
                                </div>
                                <div class="col-md-3 col-sm-3 col-xs-12">
                                    <div class="form-group">
                                        <label for="endereco">CEP</label><small class="text-danger"> *</small>
                                        <input type="text" class="form-control endereco_input" id="cep" value="" placeholder="CEP">
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-2 col-xs-12">
                                    <div class="bloc_pesquisa">
                                        <br/>
                                        <button type="button" class="btn mt-2" onclick="pesquisa_cep()" style="background-color: <?= $colores->color2 ?>; color: <?= $colores->color5 ?>"><i class="fas fa-search-location"></i> Pesquisar</button>
                                    </div>
                                </div>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <br/>
                                    <button type="button" id="add_endereco" class="btn mt-2 float-right" disabled style="background-color: <?= $colores->color2 ?>; color: <?= $colores->color5 ?>"><i class="fas fa-plus"></i> Adicionar Endereço</button>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <div class="form-group">
                                        <label for="estado">Estado</label>
                                        <input type="text" class="form-control endereco_input" id="estado" value="" placeholder="Estado" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <div class="form-group">
                                        <label for="cidade">Cidade</label>
                                        <input type="text" class="form-control" id="cidade" value="" placeholder="Cidade" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <div class="form-group">
                                        <label for="bairro">Bairro</label>
                                        <input type="text" class="form-control" id="bairro" value="" placeholder="Bairro" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label for="endereco">Endereço</label>
                                        <input type="text" class="form-control" id="endereco" value="" placeholder="Endereço" readonly>
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-2 col-xs-12">
                                    <div class="form-group">
                                        <label for="numero">Numero</label><small class="text-danger"> *</small>
                                        <input type="number" class="form-control endereco_input" id="numero" value="" placeholder="Numero">
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <div class="form-group">
                                        <label for="complemento">Complemento</label>
                                        <input type="text" class="form-control" id="complemento" value="" placeholder="Complemento">
                                    </div>
                                </div>
                            <?php endif; ?>
                            <input type="hidden" name="enderecos" id="enderecos" value=""/>
                        </div>
                        <div class="row d-none" id="lista_endereco">
                            <div class="col-md-12 co-sm-12 col-xs-12">
                                <label>Lista de Endereços</label>
                                <table class="table table-hover table-bordered">
                                    <thead>
                                        <tr>
                                        <th>Endereço</th>
                                        <th>Remover</th>
                                        </tr>
                                    </thead>
                                    <tbody class="linha_tabela">
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <?php if($usuario == null): ?>
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input class="custom-control-input" type="checkbox" id="customCheckbox2" required>
                                        <label for="customCheckbox2" class="custom-control-label">Li e concordar com os <a href="javascript:void(0)" class="links_categorias" data-toggle="modal" data-target="#termos">termos<a></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                    <input type="hidden" name="id_usuario" id="id_usuario" value="<?= @$usuario->id ?>" />
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <a href="<?= base_url($local) ?>" class="btn float-left" style="background-color: <?= $colores->color2 ?>; color: <?= $colores->color5 ?>">Voltar</a>
                                <button type="submit" class="btn float-right" id="salva" <?= $usuario == null ? "disabled" : "" ?> style="background-color: <?= $colores->color2 ?>; color: <?= $colores->color5 ?>">Salvar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="termos">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: <?= $colores->color2 ?>; color: <?= $colores->color5 ?>">
                <h4 class="modal-title">Termos para utilização e cadastro no sistema</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="background-color: <?= $colores->color2 ?>; color: <?= $colores->color5 ?>">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12" id="modal_termos">
                        <p>One fine body&hellip;</p>
                        <p>One fine body&hellip;</p>
                        <p>One fine body&hellip;</p><p>One fine body&hellip;</p>
                        <p>One fine body&hellip;</p>
                        <p>One fine body&hellip;</p><p>One fine body&hellip;</p><p>One fine body&hellip;</p><p>One fine body&hellip;</p>
                        <p>One fine body&hellip;</p>
                        <p>One fine body&hellip;</p>
                        <p>One fine body&hellip;</p>
                        <p>One fine body&hellip;</p><p>One fine body&hellip;</p>
                        <p>One fine body&hellip;</p>
                        <p>One fine body&hellip;</p><p>One fine body&hellip;</p>
                        <p>One fine body&hellip;</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer float-right">
                <button type="button" class="btn" data-dismiss="modal" style="background-color: <?= $colores->color2 ?>; color: <?= $colores->color5 ?>">Fechar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
<!-- /.modal-dialog -->
</div>