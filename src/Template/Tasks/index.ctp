<?php
/**
 * @var AppView $view
 * @var array<string,Task[]> $tasks
 */

use App\Model\Entity\Task;
use App\View\AppView;

?>
<div class="row">
    <div class="col-12 tasks">
        <div class="task-list">
            <h1>Tasks</h1>
            <?php foreach($tasks as $priority => $task): ?>
                <?= $this->element('Tasks/TaskCategory', ['priority' => $priority, 'tasks' => $task]) ?>
            <?php endforeach; ?>

            <div class="clearfix"></div>
            <?= $this->element('pagination') ?>
        </div>
    </div>
</div>
