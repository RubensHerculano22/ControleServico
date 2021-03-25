<nav class="main-header navbar navbar-expand navbar-info navbar-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav ml-auto">
      <a href="<?= base_url("") ?>">
      <li class="d-none d-sm-inline-block">
        <img src="<?= base_url("assets/img/logo_transparent.png") ?>" style="max-width: 35px; max-height: 35px;"/>
      </li>
      <li class="d-none d-sm-inline-block">
        <span class="h4 brand-text" style="color: #fff1e6">NextoYou</span>
      </li>
      </a>
      <?php foreach($categorias[0]["filho"] as $item): ?>
        <li class="nav-item dropdown itens-menu user-menu">
          <a href="#" class="nav-link dropdown-toggle">
            <?= $item["nome"] ?>
          </a>
          <ul class="dropdown-menu">
            <?php foreach($item["filho"] as $value): ?>
              <li><a class="dropdown-item" href="<?= base_url("Servico/lista/").$item["nome"]."/".$value->nome ?>"><?= $value->nome ?></a></li>
            <?php endforeach; ?>
          </ul>
        </li>
      <?php endforeach; ?>
    </ul>

    <form class="form-inline ml-4">
      <div class="form-group">
        <select class="form-control select2" style="width: 100%;" placeholder="Buscar">
        </select>
      </div>
    </form>

    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
      <?php if(!isset($dados) || empty($dados)): ?>
      <a href="<?= base_url("Usuario") ?>" class='nav-link dropdown'>Criar conta</a>
      <a href="<?= base_url("Usuario/login") ?>" class='nav-link dropdown'>Autentificar</a>
      <?php else: ?>
      <li class="nav-item dropdown user-menu">
        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
          <!-- <img src="https://www.microlins.com.br/galeria/repositorio/images/noticias/como-posicionar-melhor-seu-perfil-no-linkedin/02-Como-posicionar-melhor-seu-perfil-do-Linkedin.png" class="user-image img-circle elevation-2" alt="User Image"> -->
          <span class="d-none d-md-inline"><?= $dados->nome." ".$dados->sobrenome ?></span>
        </a>
        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <li class="bg-orange">
            <div class="text-center pt-3">
              <img src="https://www.microlins.com.br/galeria/repositorio/images/noticias/como-posicionar-melhor-seu-perfil-no-linkedin/02-Como-posicionar-melhor-seu-perfil-do-Linkedin.png" class="img-circle elevation-2" alt="User Image" style="max-width: 75px;">
            </div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12 p-4">
                <p class="text-center">
                  <?= $dados->nome." ".$dados->sobrenome ?>
                  <br/>
                  <small>Membro desde <?= formata_data_info($dados->data_criacao) ?></small>
                </p>
              </div>
            </div>
          </li>
          <li class="user-body">
            <a href="<?= base_url("Usuario/index/$dados->usuario_id") ?>" class="btn btn-default btn-flat btn-block">Minhas Informações (editar por enquanto)</a>
            <button type="button" class="btn btn-default btn-flat btn-block">Meus Serviços</button>
            <button type="button" class="btn btn-default btn-flat btn-block">Lista de favoritos</button>
            <button type="button" class="btn btn-default btn-flat btn-block">Serviços contratos</button>
            <a href="<?= base_url("Usuario/logout/$local") ?>" class="btn btn-default btn-flat btn-block">Sair</a>
          </li>
        </ul>
      </li>
      <?php endif; ?>
    </ul>
</nav>