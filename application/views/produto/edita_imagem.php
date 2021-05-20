<div class="container">
    <div class="row">
        <div class="col-sm-12 col-xs-12 col-xs-12">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Formulário de Edição de Imagens do Serviço</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 mb-5">
                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modalImagem">Adicionar nova Imagem</button>
                        </div>
                        <?php foreach($imagem as $key => $item): ?>
                            <div class="col-md-4 col-sm-4 col-xs-12 text-center">
                                <img src="data:<?= $item->tipo_imagem ?>;base64,<?= $item->img ?>" class="img-thumbnail mb-2" alt="<?= $item->nome ?>" title="<?= $item->nome ?>" style="max-height:180px;"/>
                                <div class="form-group">
                                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                        <input type="checkbox" class="custom-control-input" onclick="trocaPrincipal(<?= $item->principal ?>, <?= $item->id ?>)" id="principal<?= $key ?>" <?= $item->principal == 1 ? "checked" : "" ?>>
                                        <label class="custom-control-label" for="principal<?= $key ?>">Principal</label>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-warning" onclick="editaImagem(<?= $item->id ?>)"><i class="fas fa-edit"></i></button>
                                <button type="button" class="btn btn-danger" onclick="removeImagem(<?= $item->id ?>)"><i class="fas fa-trash-alt"></i></button>
                            </div>
                        <?php endforeach; ?>
                        <small>Talvez com o estilo outline</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalImagem" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="titulo_modal">Cadastrar nova Imagem</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="submit">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input arquivo" name="file" id="nova_imagem">
                                    <label class="custom-file-label" for="nova_imagem">Escolha um Arquivo</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 principal_input">
                            <div class="form-group">
                                <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                    <input type="checkbox" class="custom-control-input" name="principal" id="nova_imagem_principal">
                                    <label class="custom-control-label" for="nova_imagem_principal">Principal</label>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="id_servico" value="<?= $id ?>" name="id_servico" />
                        <input type="hidden" id="id_imagem" value="" name="id_imagem" />
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="submit" class="btn btn-info">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>