<!DOCTYPE html>
<html>

<head>
    <?= $header ?>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <?= $navbar ?>

        <?= $sidebar ?>

        <div class="content-wrapper">
            <?php if(isset($breadcrumb) AND $breadcrumb): ?>
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-12">
                                <ol class="breadcrumb float-sm-right">
                                    <?php foreach($breadcrumb->before as $item): ?>
                                        <li class="breadcrumb-item"><a href="<?= base_url($item->link) ?>" style="color: <?= $colores->color3 ?> "><?= $item->nome ?></a></li>
                                    <?php endforeach; ?>
                                    <li class="breadcrumb-item" style="color: <?= $colores->color2 ?>"><?= $breadcrumb->current ?></li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <section class="content">
                <?= $content ?>
            </section>
        </div>
        <footer class="main-footer">
            <strong>Copyright &copy; 2020 a 2021 <a href="<?= base_url("") ?>">NextoYou</a>.</strong> Todos os direitos reservados.
        </footer>
    </div>
    <?= $footer ?>
    <?php if(isset($javascript) && !empty($javascript)): ?>
        <?php foreach($javascript as $js): ?>
            <script src="<?= $js . "?v=" . time() ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>
</body>

</html>
