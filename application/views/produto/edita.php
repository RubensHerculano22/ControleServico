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
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="valor">Nome</label>
                                    <input type="text" class="form-control" name="nome" id="nome" placeholder="Nome">
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label>Descrição Curta(Atrativa)</label>
                                    <textarea class="form-control" rows="2" name="descricao_curta" placeholder="Descrição Curta (Atrativa)"></textarea>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12">
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
                            <div class="col-md-8 col-sm-8 col-xs-12 categoria_especifica">
                                <div class="form-group">
                                    <label>Categoria Especifica</label>
                                    <select class="custom-select" name="categoria_especifica" id="categoria_especifica">
                                        
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="estado">Estado</label>
                                    <select class="form-control select2bs4" id="estado" name="estado">
                                        <?php foreach($estados as $item): ?>
                                            <option value="<?= $item->id ?>"><?= $item->nome." - ".$item->sigla ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="estado">Cidade</label>
                                    <select class="form-control select2bs4" id="cidade" name="cidade">
                                        
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-3 col-xs-12">
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
                            <div class="col-md-3 col-sm-4 col-xs-12">
                                <div class="form-group">
                                    <label for="quantidade">Quantidade Disponivel</label>
                                    <input type="number" class="form-control" name="quantidade" id="quantidade" placeholder="Quantidade">
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-4 col-xs-12">
                                <div class="form-group">
                                    <label for="caucao">Caução</label>
                                    <input type="text" class="form-control preco" name="caucao" id="caucao" placeholder="Caução">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 col-sm-4 col-sm-12">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="local_servico" name="local" val="1">
                                    <label class="form-check-label" for="local_servico">Caso o Serviço seja executado em um local especifico</label>
                                </div>
                            </div>
                            <div class="col-md-9 col-sm-8 col-xs-12" id="endereco_input">
                                <label for="endereco">Endereço</label>
                                <input type="text" class="form-control" name="endereco" id="endereco" placeholder="Endereço"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 col-sm-3 col-xs-12">
                                <div class="form-group">
                                    <label>Formas de Pagamento</label>
                                    <select class="form-control select2bs4" name="pagamento" id="pagamento" data-placeholder="Formas de Pagamento" style="width: 100%;">
                                        <?php foreach($pagamento as $item): ?>
                                            <optgroup label="<?= $item->forma_pagamento ?>">
                                                <?php foreach($item->tipos as $value): ?>
                                                    <option value="<?= $value->id ?>"><?= $value->nome ?></option>
                                                <?php endforeach; ?>
                                            </optgroup>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-12">
                                <div class="form-group">
                                    <label>Quantidade de Vezes que realiza</label>
                                    <select class="form-control select2bs4" name="vezes" id="vezes" data-placeholder="Quantidade de Vezes" style="width: 100%;">
                                        <option value="1">À vista</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                    </select>
                                </div>               
                            </div>
                            <div class="col-md-2 col-sm-2 col-xs-12">
                                <div class="form-group tipo_servico">
                                    <label for="valor">Tipo</label>
                                    <div class="form-check">
                                        <input class="form-check-input" value="1" type="radio" id="juros1" name="juros">
                                        <label class="form-check-label">Com Juros</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" value="2" type="radio" id="juros2" name="juros">
                                        <label class="form-check-label">Sem Juros</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 co-sm-2 col-xs-12">
                                <br/>
                                <button class="btn btn-info" id="adicionar_meio_pagamento">Adicionar Meio de Pagamento</button>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12 d-none" id="lista_pag">
                                <h4>Lista de Forma de Pagamento</h4>
                                <ol class="list-group list-group-numbered" id="lista_pagamento">
                                    
                                </ol>
                            </div>
                            <input type="hidden" value="" id="lista_pagamento_input" name="lista_tipo_pagamento"/>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <label for="valor">Descrição Completa do serviço <small>(Serviço que possuem maior descrição com muito recursos visuais costumam ter maior contratação)</small></label>
                                <textarea id="summernote" name="descricao_completa">
                                    Place <em>some</em> <u>text</u> <strong>here</strong>
                                </textarea>
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