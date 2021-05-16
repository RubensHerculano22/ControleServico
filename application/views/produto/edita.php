<div class="container">
    <div class="row">
        <div class="col-sm-12 col-xs-12 col-xs-12">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Formulário de Cadastro de Serviço</h3>
                </div>
                <form id="submit">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-5 col-sm-5 col-xs-12">
                                <div class="form-group">
                                    <label for="valor">Nome</label>
                                    <input type="text" class="form-control" name="nome" id="nome" placeholder="Nome">
                                </div>
                            </div>
                            <div class="col-md-7 col-sm-7 col-xs-12">
                                <div class="form-group">
                                    <label>Descrição Curta(Atrativa)</label>
                                    <textarea class="form-control" rows="2" name="descricao_curta" placeholder="Descrição Curta (Atrativa)"></textarea>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-2 col-xs-12">
                                <div class="form-group">
                                    <label>Categoria Principal</label>
                                    <select class="custom-select" name="categoria_principal" id="categoria_principal">
                                        <option disabled selected>Selecione uma opção</option>
                                        <?php foreach($categoria as $item): ?>
                                            <option value="<?= $item->id ?>"><?= $item->nome ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12 categoria_especifica">
                                <div class="form-group">
                                    <label>Categoria Especifica</label>
                                    <select class="custom-select" name="categoria_especifica" id="categoria_especifica">
                                        
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-12">
                                <div class="form-group">
                                    <label for="valor">Valor</label>
                                    <input type="text" class="form-control preco" name="valor" id="valor" placeholder="Valor">
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-12">
                                <div class="form-group tipo_servico">
                                    <label for="valor">Tipo de Serviço</label>
                                    <div class="form-check">
                                        <input class="form-check-input" value="1" type="radio" name="tipo_servico">
                                        <label class="form-check-label">Prestação de Serviço</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" value="2" type="radio" name="tipo_servico">
                                        <label class="form-check-label">Aluguel de Equipamento</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer justify-content-between">
                        <a href="<?= base_url("Servico/gerenciar_servico/$id") ?>" class="btn btn-info">Voltar</a>
                        <button type="submit" class="btn btn-info ">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>