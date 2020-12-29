<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item d-none d-sm-inline-block">
        <a href="<?= base_url("") ?>" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="<?= base_url("Home/lista") ?>" class="nav-link">Lista</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="<?= base_url("Home/detalhes"); ?>" class="nav-link">Detalhes</a>
      </li>
    </ul>

    <!-- SEARCH FORM -->
    <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form>
    <ul class="navbar-nav ml-auto">
      <a href="<?= base_url("Usuario") ?>" class='nav-link dropdown'>Criar conta</a>
      <li class="nav-item dropdown user-menu">
        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
          <!-- <img src="https://www.microlins.com.br/galeria/repositorio/images/noticias/como-posicionar-melhor-seu-perfil-no-linkedin/02-Como-posicionar-melhor-seu-perfil-do-Linkedin.png" class="user-image img-circle elevation-2" alt="User Image"> -->
          <span class="d-none d-md-inline">Alexander Pierce</span>
        </a>
        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <li class="bg-warning">
            <!-- <img src="https://www.microlins.com.br/galeria/repositorio/images/noticias/como-posicionar-melhor-seu-perfil-no-linkedin/02-Como-posicionar-melhor-seu-perfil-do-Linkedin.png" class="img-circle elevation-2" alt="User Image"> -->
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12 p-4">
                <p>
                  Alexander Pierce - Web Developer
                  <small>Member since Nov. 2012</small>
                </p>
              </div>
            </div>
          </li>
          <li class="user-body">
            <button type="button" class="btn btn-default btn-flat btn-block">Minhas Informações</button>
            <button type="button" class="btn btn-default btn-flat btn-block">Meus Serviços</button>
            <button type="button" class="btn btn-default btn-flat btn-block">Lista de favoritos</button>
            <button type="button" class="btn btn-default btn-flat btn-block">Serviços contratos</button>
            <button type="button" class="btn btn-default btn-flat btn-block">Sair</button>
          </li>
        </ul>
      </li>
    </ul>
</nav>