<div class="container">
    <div class="row">
        <div class="col-sm-12 col-xs-12 col-xs-12">
            <div class="card card-default">
                <div class="card-header" style="background-color: <?= $colores->color2 ?>; color: <?= $colores->color5 ?>">
                    <h3 class="card-title">Formulário de Cadastro de Serviço</h3>
                </div>
                <form id="submit">
                    <div class="card-body p-0">
                        <div class="bs-stepper">
                            <div class="row bs-stepper-header" role="tablist">
                                <!-- your steps here -->
                                <div class="step" data-target="#informacoes-part">
                                    <button type="button" class="step-trigger" role="tab" aria-controls="informacoes-part" id="informacoes-part-trigger">
                                        <span class="bs-stepper-circle" style="background-color: <?= $colores->color1 ?>; color: <?= $colores->color5 ?>">1</span>
                                        <span class="bs-stepper-label">Informações do Serviço/Produto</span>
                                    </button>
                                </div>
                                <div class="line"></div>
                                <div class="step" data-target="#descricao-part">
                                    <button type="button" class="step-trigger" role="tab" aria-controls="horarios-part" id="descricao-part-trigger">
                                        <span class="bs-stepper-circle" style="background-color: <?= $colores->color1 ?>; color: <?= $colores->color5 ?>">2</span>
                                        <span class="bs-stepper-label">Descrição Completa</span>
                                    </button>
                                </div>
                                <div class="line"></div>
                                <div class="step" data-target="#horarios-part">
                                    <button type="button" class="step-trigger" role="tab" aria-controls="horarios-part" id="horarios-part-trigger">
                                        <span class="bs-stepper-circle" style="background-color: <?= $colores->color1 ?>; color: <?= $colores->color5 ?>">3</span>
                                        <span class="bs-stepper-label">Horarios</span>
                                    </button>
                                </div>
                                <div class="line"></div>
                                <div class="step" data-target="#imagem-part">
                                    <button type="button" class="step-trigger" role="tab" aria-controls="imagem-part" id="imagem-part-trigger">
                                        <span class="bs-stepper-circle" style="background-color: <?= $colores->color1 ?>; color: <?= $colores->color5 ?>">4</span>
                                        <span class="bs-stepper-label">Imagem</span>
                                    </button>
                                </div>
                            </div>
                            <div class="bs-stepper-content">
                                <!-- your steps content here -->
                                <div id="informacoes-part" class="content" role="tabpanel" aria-labelledby="informacoes-part-trigger">
                                    <div class="row">
                                        <small class="text-danger">* Obrigatorios</small><br/>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label for="valor">Nome</label><small class="text-danger"> *</small>
                                                <input type="text" class="form-control" name="nome" id="nome" placeholder="Nome" required>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label>Descrição Curta(Atrativa)</label><small class="text-danger"> *</small>
                                                <textarea class="form-control" rows="2" name="descricao_curta" id="descricao_curta" placeholder="Descrição Curta (Atrativa)" required></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                            <div class="form-group">
                                                <label>Categoria Principal</label><small class="text-danger"> *</small>
                                                <select class="custom-select" name="categoria_principal" id="categoria_principal" required>
                                                    <option disabled selected>Selecione uma opção</option>
                                                    <?php foreach($categoria as $item): ?>
                                                        <option value="<?= $item->id ?>"><?= $item->nome ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-5 col-sm-5 col-xs-12 categoria_especifica">
                                            <div class="form-group">
                                                <label>Categoria Especifica</label><small class="text-danger"> *</small>
                                                <select class="custom-select" name="categoria_especifica" id="categoria_especifica" required>
                                                    
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <div class="form-group">
                                                <label for="valor">Valor</label>
                                                <input type="text" class="form-control preco" name="valor" id="valor" placeholder="Valor">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <div class="form-group tipo_servico">
                                                <label for="valor">Tipo de Serviço</label><small class="text-danger"> *</small>
                                                <div class="form-check">
                                                    <input class="form-check-input" value="1" type="radio" name="tipo_servico" required>
                                                    <label class="form-check-label">Prestação de Serviço</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" value="2" type="radio" name="tipo_servico" required>
                                                    <label class="form-check-label">Aluguel de Equipamento</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-4 col-xs-12 d-none aluguel_equipamentos">
                                            <div class="form-group">
                                                <label for="quantidade">Quantidade Disponivel</label><small class="text-danger"> *</small>
                                                <input type="number" class="form-control" name="quantidade" id="quantidade" placeholder="Quantidade">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-4 col-xs-12 d-none aluguel_equipamentos">
                                            <div class="form-group">
                                                <label for="caucao">Caução</label>
                                                <input type="text" class="form-control preco" name="caucao" id="caucao" placeholder="Caução">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-sm-12 mb-2">
                                            <label>Possui estabelecimento local?</label>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="local_servico" name="local" val="1">
                                                <label class="form-check-label" for="local_servico">Sim</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-6 col-xs-12 area_servico">
                                            <div class="form-group">
                                                <label for="estado">Estado</label><small class="text-danger"> *</small>
                                                <select class="form-control select2bs4" id="estado" name="estado">
                                                    <?php foreach($estados as $item): ?>
                                                        <option value="<?= $item->id ?>" <?= $item->id == $cidade->id_estado ? "selected" : false ?>><?= $item->nome." - ".$item->sigla ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-6 col-xs-12 area_servico">
                                            <div class="form-group">
                                                <label for="estado">Cidade</label><small class="text-danger"> *</small>
                                                <select class="form-control select2bs4" id="cidade" name="cidade">
                                                    <?php foreach($lista_cidade as $item): ?>
                                                        <option class="option_cidades" value="<?= $item->ID ?>" <?= $item->ID == $cidade->id_cidade ? "selected" : false ?>><?= $item->Nome ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-3 col-xs-12 d-none local_especifico">
                                            <div class="form-group">
                                                <label for="endereco">CEP</label><small class="text-danger"> *</small>
                                                <input type="text" class="form-control endereco_input" id="cep" value="" placeholder="CEP">
                                            </div>
                                        </div>
                                        <div class="col-md-9 col-sm-9 col-xs-12 d-none local_especifico">
                                            <div class="bloc_pesquisa">
                                                <br/>
                                                <button type="button" class="btn mt-2" onclick="pesquisa_cep()" style="background-color: <?= $colores->color2 ?>; color: <?= $colores->color5 ?>"><i class="fas fa-search-location"></i> Pesquisar</button>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-4 col-xs-12 d-none local_especifico">
                                            <div class="form-group">
                                                <label for="estado">Estado</label>
                                                <input type="text" class="form-control endereco_input" id="estado_input" name="estado" value="" placeholder="Estado" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-4 col-xs-12 d-none local_especifico">
                                            <div class="form-group">
                                                <label for="cidade">Cidade</label>
                                                <input type="text" class="form-control" id="cidade_input" value="" name="cidade" placeholder="Cidade" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-4 col-xs-12 d-none local_especifico">
                                            <div class="form-group">
                                                <label for="bairro">Bairro</label>
                                                <input type="text" class="form-control" id="bairro_input" value="" name="bairro" placeholder="Bairro" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12 d-none local_especifico">
                                            <div class="form-group">
                                                <label for="endereco">Endereço</label>
                                                <input type="text" class="form-control" id="endereco_input" value="" name="endereco" placeholder="Endereço" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-sm-2 col-xs-12 d-none local_especifico">
                                            <div class="form-group">
                                                <label for="numero">Numero</label><small class="text-danger"> *</small>
                                                <input type="number" class="form-control endereco_input" id="numero_input" value="" name="numero" placeholder="Numero">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-4 col-xs-12 d-none local_especifico">
                                            <div class="form-group">
                                                <label for="complemento">Complemento</label>
                                                <input type="text" class="form-control" id="complemento_input" value="" name="complemento" placeholder="Complemento">
                                            </div>
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
                                        <div class="col-md-3 col-sm-3 col-xs-12">
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
                                        <div class="col-md-3 co-sm-3 col-xs-12">
                                            <br/>
                                            <button class="btn" id="adicionar_meio_pagamento" style="background-color: <?= $colores->color2 ?>; color: <?= $colores->color5 ?>">Adicionar Meio de Pagamento</button>
                                        </div>
                                        <div class="col-md-12 col-sm-12 col-xs-12 d-none" id="lista_pag">
                                            <h4>Lista de Forma de Pagamento</h4>
                                            <ol class="list-group list-group-numbered" id="lista_pagamento">
                                                
                                            </ol>
                                        </div>
                                        <input type="hidden" value="" id="lista_pagamento_input" name="lista_tipo_pagamento"/>
                                        <div class="col-md-12 col-sm-12 col-xs-12 mt-4">
                                            <button type="button" class="btn proximo" style="background-color: <?= $colores->color2 ?>; color: <?= $colores->color5 ?>" data-id="1" data-acao="prox">Proximo</button>
                                        </div>
                                    </div>
                                </div>
                                <div id="descricao-part" class="content" role="tabpanel" aria-labelledby="descricao-part-trigger">
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label for="valor">Descrição Completa do serviço <small>(Serviço que possuem maior descrição com muito recursos visuais costumam ter maior contratação)</small></label>
                                            <textarea id="summernote" name="descricao_completa">
                                                Place <em>some</em> <u>text</u> <strong>here</strong>
                                            </textarea>
                                        </div>
                                        <div class="col-md-12 col-sm-12 col-xs-12 mt-4">
                                            <button type="button" class="btn btn-info" onclick="previousForm()">Anterior</button>
                                            <button type="button" class="btn btn-info" onclick="nextForm()">Proximo</button>
                                        </div>
                                    </div>
                                </div>
                                <div id="horarios-part" class="content" role="tabpanel" aria-labelledby="horarios-part-trigger">
                                    <h3>Personalização de Horario</h3>
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label>Dia da Semana</label>
                                                <select class="form-control select2bs4" name="dia_semana" id="dia_semana" data-placeholder="Dia da Semana" style="width: 100%;">
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
                                                <input type="text" class="form-control" name="horario_inicio" id="horario_inicio" placeholder="Inicio do Funcionamento" data-inputmask='"mask": "99:99"' data-mask>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                            <div class="form-group">
                                                <label for="valor">Final do Funcionamento</label>
                                                <input type="text" class="form-control" name="horario_fim" id="horario_fim" placeholder="Final do Funcionamento" data-inputmask='"mask": "99:99"' data-mask>
                                            </div>
                                        </div>
                                        <div class="col-md-4 co-sm-4 col-xs-12">
                                            <br/>
                                            <button class="btn btn-info" id="adicionar_horario">Adicionar Horario</button>
                                        </div>
                                        <div class="col-md-12 col-sm-12 col-xs-12 d-none" id="lista_de_horario">
                                            <h4>Lista de Horario</h4>
                                            <ol class="list-group list-group-numbered" id="lista_horario">
                                            </ol>
                                        </div>
                                        <input type="hidden" value="" id="lista_horario_input" name="lista_tipo_horario"/>
                                        <div class="col-md-12 col-sm-12 col-xs-12 mt-4">
                                            <button type="button" class="btn btn-info" onclick="previousForm()">Anterior</button>
                                            <button type="button" class="btn btn-info" onclick="nextForm()">Proximo</button>
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
                                    <button type="button" class="btn btn-info" onclick="previousForm()">Anterior</button>
                                    <button type="submit" class="btn btn-info">Salvar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>