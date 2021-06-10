<div class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 pt-5">
            <div class="card">
                <div class="card-header" style="background-color: <?= $colores->color2 ?>">
                    <h3 class="card-title" style="color: <?= $colores->color5 ?>""><?= $endereco == false ? "Formulário de Cadastro de Endereço" : "Formulário de Edição de Endereço" ?></h3>
                </div>
                <form id="submit" role="form">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 col-sm-3 col-xs-12">
                                <div class="form-group">
                                    <label for="endereco">CEP</label><small class="text-danger"> *</small>
                                    <input type="text" class="form-control" name="cep" id="cep" value="<?= set_value('cep', @$endereco->cep); ?>" placeholder="CEP" required>
                                </div>
                            </div>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <div class="bloc_pesquisa">
                                    <br/>
                                    <button type="button" class="btn mt-2" onclick="pesquisa_cep()" style="background-color: <?= $colores->color2 ?>; color: <?= $colores->color5 ?>"><i class="fas fa-search-location"></i> Pesquisar</button>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <div class="form-group">
                                    <label for="estado">Estado</label>
                                    <input type="text" class="form-control" name="estado" id="estado" value="<?= set_value('estado', @$endereco->estado); ?>"" placeholder="Estado" readonly>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <div class="form-group">
                                    <label for="cidade">Cidade</label>
                                    <input type="text" class="form-control" name="cidade" id="cidade" value="<?= set_value('cidade', @$endereco->cidade); ?>"" placeholder="Cidade" readonly>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <div class="form-group">
                                    <label for="bairro">Bairro</label>
                                    <input type="text" class="form-control" name="bairro" id="bairro" value="<?= set_value('bairro', @$endereco->bairro); ?>"" placeholder="Bairro" readonly>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="endereco">Endereço</label>
                                    <input type="text" class="form-control" name="endereco" id="endereco" value="<?= set_value('endereco', @$endereco->endereco); ?>"" placeholder="Endereço" readonly>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-2 col-xs-12">
                                <div class="form-group">
                                    <label for="numero">Numero</label><small class="text-danger"> *</small>
                                    <input type="number" class="form-control" name="numero" id="numero" value="<?= set_value('numero', @$endereco->numero); ?>"" placeholder="Numero" required>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <div class="form-group">
                                    <label for="complemento">Complemento</label>
                                    <input type="text" class="form-control" name="complemento" id="complemento" value="<?= set_value('complemento', @$endereco->complemento); ?>"" placeholder="Complemento">
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" value="<?= $id ?>" name="id" />
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <a href="<?= base_url($local) ?>" class="btn float-left" style="background-color: <?= $colores->color2 ?>; color: <?= $colores->color5 ?>">Voltar</a>
                                <button type="submit" class="btn float-right" id="salva" <?= $endereco == null ? "disabled" : "" ?> style="background-color: <?= $colores->color2 ?>; color: <?= $colores->color5 ?>">Salvar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
