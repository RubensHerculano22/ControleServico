<div class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 pt-5">
            <div class="card">
                <div class="card-header" style="background-color: <?= $colores->color2 ?>">
                    <h3 class="card-title">Formulário de Cadastro de Novos Usuarios</h3>
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
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <hr>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-12">
                                <div class="form-group">
                                    <label for="endereco">CEP</label><small class="text-danger"> *</small>
                                    <input type="text" class="form-control" name="cep" id="cep" value="<?= set_value('cep', @$usuario->cep); ?>" placeholder="CEP" required>
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
                                <button type="button" id="add_endereco" class="btn mt-2 float-right" style="background-color: <?= $colores->color2 ?>; color: <?= $colores->color5 ?>"><i class="fas fa-plus"></i> Adicionar Endereço</button>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <div class="form-group">
                                    <label for="estado">Estado</label>
                                    <input type="text" class="form-control" name="estado" id="estado" value="<?= set_value('estado', @$usuario->estado); ?>" placeholder="Estado" readonly>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <div class="form-group">
                                    <label for="cidade">Cidade</label>
                                    <input type="text" class="form-control" name="cidade" id="cidade" value="<?= set_value('cidade', @$usuario->cidade); ?>" placeholder="Cidade" readonly>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <div class="form-group">
                                    <label for="bairro">Bairro</label>
                                    <input type="text" class="form-control" name="bairro" id="bairro" value="<?= set_value('bairro', @$usuario->bairro); ?>" placeholder="Bairro" readonly>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="endereco">Endereço</label>
                                    <input type="text" class="form-control" name="endereco" id="endereco" value="<?= set_value('endereco', @$usuario->endereco); ?>" placeholder="Endereço" readonly>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-2 col-xs-12">
                                <div class="form-group">
                                    <label for="numero">Numero</label><small class="text-danger"> *</small>
                                    <input type="number" class="form-control" name="numero" id="numero" value="<?= set_value('numero', @$usuario->numero); ?>" placeholder="Numero">
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <div class="form-group">
                                    <label for="complemento">Complemento</label><small class="text-danger"> *</small>
                                    <input type="text" class="form-control" name="complemento" id="complemento" value="<?= set_value('complemento', @$usuario->complemento); ?>" placeholder="Complemento">
                                </div>
                            </div>
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
                                    <tbody>
                                        <tr>
                                            <td>183</td>
                                            <td>John Doe</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="id_usuario" id="id_usuario" value="<?= @$usuario->id ?>" />
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <a href="<?= base_url($local) ?>" class="btn btn-info float-left">Voltar</a>
                                <button type="submit" class="btn btn-info float-right">Salvar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>