<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Task $task;
 */
?>
<div class="row">
    <div class="col-12 tasks">
        <div>
            <h4 class="text-center">Task <?= $task->id ?></h4>
            <div class="row">
                <div class="col-2 fw-bold text-end"><?= __('ID') ?></div>
                <div class="col-8"><?= $task->id ?></div>
            </div>
            <div class="row">
                <div class="col-2 fw-bold text-end"><?= __('Title') ?></div>
                <div class="col-8"><?= h($task->title) ?></div>
            </div>
            <div class="row">
                <div class="col-2 fw-bold text-end"><?= __('Type') ?></div>
                <div class="col-8"><?= h($task->status) ?></div>
            </div>
            <div class="row">
                <div class="col-2 fw-bold text-end"><?= __('Description') ?></div>
                <div class="col-8"><?= h($task->description) ?></div>
            </div>
            <div class="row">
                <div class="col-2 fw-bold text-end"><?= __('Comment') ?></div>
                <div class="col-8"><?= h($task->comment) ?></div>
            </div>
            <div class="row">
                <div class="col-2 fw-bold text-end"><?= __('Author') ?></div>
                <div class="col-8"><?= h($task->author->name) ?></div>
            </div>
            <div class="row">
                <div class="col-2 fw-bold text-end"><?= __('Executor') ?></div>
                <div class="col-8"><?= isset($task->executor) ? h($task->executor->name) : __('No executor') ?></div>
            </div>
            <div class="row mb-4">
                <div class="col-2 fw-bold text-end"><?= __('State') ?></div>
                <div class="col-8"><?= __($task->state) ?></div>
            </div>
            <div class="row p-3">
                <div class="col">
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $task->id], ['class' => 'btn btn-outline-primary']); ?>
                    <?= $this->Form->postLink(
                        __('Delete'),
                        ['action' => 'delete', $task->id],
                        ['confirm' => __('Are you sure you want to delete # {0}?', $task->id), 'class' => 'btn btn-danger']
                    )
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
