<div class="container">
    <div class="row">
        <div class="col-sm-12 col-xs-12 col-xs-12">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">bs-stepper</h3>
                </div>
                <div class="card-body p-0">
                    <div class="bs-stepper">
                        <div class="bs-stepper-header" role="tablist">
                            <!-- your steps here -->
                            <div class="step" data-target="#informacoes-part">
                                <button type="button" class="step-trigger" role="tab" aria-controls="informacoes-part" id="informacoes-part-trigger">
                                    <span class="bs-stepper-circle">1</span>
                                    <span class="bs-stepper-label">Informações do Serviço/Produto</span>
                                </button>
                            </div>
                            <div class="line"></div>
                            <div class="step" data-target="#horarios-part">
                                <button type="button" class="step-trigger" role="tab" aria-controls="horarios-part" id="horarios-part-trigger">
                                    <span class="bs-stepper-circle">2</span>
                                    <span class="bs-stepper-label">Horarios</span>
                                </button>
                            </div>
                            <div class="line"></div>
                            <div class="step" data-target="#imagem-part">
                                <button type="button" class="step-trigger" role="tab" aria-controls="imagem-part" id="imagem-part-trigger">
                                    <span class="bs-stepper-circle">3</span>
                                    <span class="bs-stepper-label">Imagem</span>
                                </button>
                            </div>
                        </div>
                        <div class="bs-stepper-content">
                            <!-- your steps content here -->
                            <div id="informacoes-part" class="content" role="tabpanel" aria-labelledby="informacoes-part-trigger">
                                <div class="row">
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="valor">Nome</label>
                                            <input type="text" class="form-control" name="nome" id="nome" placeholder="Nome">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
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
                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                        <div class="form-group">
                                            <label>Categoria Especifica</label>
                                            <select class="form-control select2bs4" name="categoria_especifica" id="categoria_especifica">
                                                <optgroup label="Swedish Cars">
                                                    <option>option 1</option>
                                                    <option>option 2</option>
                                                </optgroup>
                                                <optgroup label="Swedish Cars">
                                                    <option>option 3</option>
                                                    <option>option 4</option>
                                                    <option>option 5</option>
                                                </optgroup>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <div class="form-group">
                                            <label for="valor">Valor (Colocar mask de valor)</label>
                                            <input type="text" class="form-control" name="valor" id="valor" placeholder="Valor">
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <div class="form-group tipo_servico">
                                            <label for="valor">Tipo de Serviço</label>
                                            <div class="form-check">
                                                <input class="form-check-input" value="1" type="radio" name="tipo">
                                                <label class="form-check-label">Prestação de Serviço</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" value="2" type="radio" name="tipo">
                                                <label class="form-check-label">Aluguel de Equipamento</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-xs-12 d-none" id="aluguel_equipamentos">
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <div class="form-group">
                                                    <label for="quantidade">Quantidade Disponivel</label>
                                                    <input type="text" class="form-control" name="quantidade" id="quantidade" placeholder="Quantidade">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <div class="form-group">
                                                    <label for="caucao">Caução</label>
                                                    <input type="text" class="form-control" name="caucao" id="caucao" placeholder="Caução">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    Liberar para o pessoal definir em quantas vezes.
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label>Formas de Pagamento</label>
                                            <select class="form-control select2bs4" multiple="multiple" name="pagamento" data-placeholder="Select a State" style="width: 100%;">
                                                <option>Alabama</option>
                                                <option>Alaska</option>
                                                <option>California</option>
                                                <option>Delaware</option>
                                                <option>Tennessee</option>
                                                <option>Texas</option>
                                                <option>Washington</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label for="valor">Descrição Completa do serviço <small>(Serviço que possuem maior descrição com muito recursos visuais costumam ter maior contratação)</small></label>
                                        <textarea id="summernote">
                                            Place <em>some</em> <u>text</u> <strong>here</strong>
                                        </textarea>
                                    </div>
                                </div>
                                <button class="btn btn-info" onclick="nextForm()">Proximo</button>
                            </div>
                            <div id="horarios-part" class="content" role="tabpanel" aria-labelledby="horarios-part-trigger">
                                <h3>Personalização de Horario</h3>
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label>Dia da Semana</label>
                                            <select class="form-control select2bs4" name="dia da semana" data-placeholder="Select a State" style="width: 100%;">
                                                <option value="1">Domingo</option>
                                                <option value="2">Segunda-Feira</option>
                                                <option value="3">Terça-Feira</option>
                                                <option value="4">Quarta-Feira</option>
                                                <option value="5">Quinta-Feira</option>
                                                <option value="6">Sexta-Feira</option>
                                                <option value="7">Sabado</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <div class="form-group">
                                            <label for="valor">Inicio do Funcionamento</label>
                                            <input type="text" class="form-control" name="data_inicio" id="data_inicio" placeholder="Inicio do Funcionamento">
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <div class="form-group">
                                            <label for="valor">Final do Funcionamento</label>
                                            <input type="text" class="form-control" name="data_fim" id="data_fim" placeholder="Final do Funcionamento">
                                        </div>
                                    </div>
                                    <div class="col-md-4 co-sm-4 col-xs-12">
                                        <br/>
                                        <button class="btn btn-info">Adicionar Horario</button>
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <h4>Lista de Horario</h4>
                                        <ol class="list-group list-group-numbered">
                                            <li class="list-group-item">asasdasd</li>
                                            <li class="list-group-item">ads</li>
                                            <li class="list-group-item">dsadsadsads</li>
                                        </ol>
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-xs-12 mt-4">
                                        <button class="btn btn-info" onclick="previousForm()">Anterior</button>
                                        <button class="btn btn-info" onclick="nextForm()">Proximo</button>
                                    </div>
                                </div>
                            </div>
                            <div id="imagem-part" class="content" role="tabpanel" aria-labelledby="imagem-part-trigger">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div id="actions" class="row">
                                            <div class="col-lg-12">
                                                <div class="btn-group">
                                                    <span class="btn btn-info fileinput-button">
                                                        <i class="fas fa-plus"></i>
                                                        <span>Adicionar Imagem</span>
                                                    </span>
                                                    <button type="reset" class="btn btn-warning cancel">
                                                        <i class="fas fa-times-circle"></i>
                                                        <span>Cancelar todas as Imagens</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="table table-striped files" id="previews">
                                            <div id="template" class="row mt-2">
                                                <div class="col-auto">
                                                    <span class="preview"><img src="data:," alt="" data-dz-thumbnail /></span>
                                                </div>
                                                <div class="col d-flex align-items-center">
                                                    <p class="mb-0">
                                                        <span class="lead" data-dz-name></span>
                                                        (<span data-dz-size></span>)
                                                    </p>
                                                    <strong class="error text-danger" data-dz-errormessage></strong>
                                                </div>
                                                <div class="col-4 d-flex align-items-center">
                                                    <div class="progress progress-striped active w-100" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                                                        <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
                                                    </div>
                                                </div>
                                                <div class="col-auto d-flex align-items-center">
                                                    <div class="btn-group">
                                                        <button data-dz-remove class="btn btn-danger delete">
                                                            <i class="fas fa-trash"></i>
                                                            <span>Delete</span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-info" onclick="previousForm()">Anterior</button>
                                <button type="submit" class="btn btn-info">Salvar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>