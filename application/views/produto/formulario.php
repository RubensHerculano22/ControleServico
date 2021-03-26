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
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <div class="form-group">
                                            <label>Categoria Principal</label>
                                            <select class="custom-select" name="categoria_principal">
                                                <option>option 1</option>
                                                <option>option 2</option>
                                                <option>option 3</option>
                                                <option>option 4</option>
                                                <option>option 5</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <div class="form-group">
                                            <label>Categoria Principal</label>
                                            <select class="custom-select" name="categoria_principal">
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
                                <button class="btn btn-primary" onclick="nextForm()">Proximo</button>
                            </div>
                            <div id="horarios-part" class="content" role="tabpanel" aria-labelledby="horarios-part-trigger">
                                <div class="form-group">
                                    <label for="exampleInputFile">File input</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="exampleInputFile">
                                            <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                        </div>
                                        <div class="input-group-append">
                                            <span class="input-group-text">Upload</span>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-primary" onclick="previousForm()">Previous</button>
                                <button class="btn btn-primary" onclick="nextForm()">Next</button>
                            </div>
                            <div id="imagem-part" class="content" role="tabpanel" aria-labelledby="imagem-part-trigger">
                                <div class="form-group">
                                    <label for="exampleInputFile">File input</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="exampleInputFile">
                                            <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                        </div>
                                        <div class="input-group-append">
                                            <span class="input-group-text">Upload</span>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-primary" onclick="previousForm()">Previous</button>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>