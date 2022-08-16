<?php
$this->Paginator->setTemplates([
    'number' => '<li class="page-item"><a class="page-link" href="{{url}}" data-abc="true">{{text}}</a></li>',
    'current' => '<li class="page-item"><a class="page-link active" href="{{url}}" data-abc="true">{{text}}</a></li>',
    'first' => '<li class="page-item"><a class="page-link " href="{{url}}" data-abc="true">{{text}}</a></li>',
    'prevActive' => '<li class="page-item"><a class="page-link " href="{{url}}" data-abc="true">{{text}}</a></li>',
    'prevDisabled' => '<li class="page-item"><a class="page-link" disabled href="{{url}}" data-abc="true">{{text}}</a></li>',
    'nextActive' => '<li class="page-item"><a class="page-link " href="{{url}}" data-abc="true">{{text}}</a></li>',
    'nextDisabled' => '<li class="page-item"><a class="page-link " disabled href="{{url}}" data-abc="true">{{text}}</a></li>',
    'last' => '<li class="page-item"><a class="page-link " href="{{url}}" data-abc="true">{{text}}</a></li>',
]);
?>
<nav class="mt-2">
    <ul class="pagination d-flex justify-content-center flex-wrap pagination-flat pagination-success">
        <?= $this->Paginator->first('<<') ?>
        <?= $this->Paginator->prev('<') ?>
        <?= $this->Paginator->numbers() ?>
        <?= $this->Paginator->next('>') ?>
        <?= $this->Paginator->last('>>') ?>
    </ul>
</nav>
