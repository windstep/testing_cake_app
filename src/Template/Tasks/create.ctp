<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Task $task;
 */
?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="col-6">
                    <?= $this->Form->create($task, ['url' => ['action' => 'store']]) ?>
                    <fieldset>
                        <legend><?= __('Edit Task') ?></legend>
                        <?php
                        echo $this->Form->control('title', ['class' => 'form-control mb-4']);
                        echo $this->Form->control('description', ['class' => 'form-control mb-4']);
                        echo $this->Form->select('status', $statuses, ['default' => $defaultStatus, 'class' => 'form-control mb-4']);
                        echo $this->Form->select('state', $states, ['default' => $defaultState, 'class' => 'form-control mb-4']);
                        echo $this->Form->select('executor_id', $users, ['class' => 'form-control mb-4']);
                        ?>
                    </fieldset>
                    <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-outline-primary']) ?>
                    <?= $this->Form->end() ?>
                </div>
            </div>
        </div>
    </div>
</div>
