<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css('bootstrap.min.css') ?>
    <?= $this->Html->css('style.css') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
<header class="bg-light mb-5">
    <div class="container d-flex flex-wrap">
        <div class="nav">&nbsp;</div>
        <ul class="nav">
            <?php if (!($_SESSION['Auth']['id'] ?? null) ): ?>
                <li class="nav-item">
                    <a href="/login" class="nav-link px-2">Login</a>
                </li>
            <?php else: ?>
                <li class="nav-item">
                    <a href="/logout" class="nav-link px-2">Logout</a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</header>
<?= $this->Flash->render() ?>
<div class="container page-todo bootstrap snippets bootdeys">
    <?= $this->fetch('content') ?>
</div>
</body>
</html>
