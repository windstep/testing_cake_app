<?php
/**
 * @var AppView $this
 * @var array<string,Task[]> $tasks
 */

use App\Model\Entity\Task;
use App\View\AppView;

?>

<section style="background-color: #eee;">
<div class="container py-5">
    <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col col-lg-9 col-xl-7">
            <div class="card rounded-3">
                <div class="card-body p-4">

                    <h4 class="text-center my-3 pb-3">Tasks</h4>

                    <table class="table mb-4">
                        <thead>
                        <tr>
                            <th scope="col">
                                <?= $this->Paginator->sort('id', 'No.') ?>
                            </th>
                            <th scope="col"><?= $this->Paginator->sort('created,status', 'Title') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('status,created', 'Type') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('created', 'Created') ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($tasks as $task): /** @var Task $task */ ?>
                            <tr>
                                <th scope="row"><?= $this->Html->link($task->id, ['action' => 'view', 'id' => $task->id]) ?></th>
                                <td><?= $this->Html->link(h($task->title), ['action' => 'view', 'id' => $task->id]) ?></td>
                                <td><?= __($task->status) ?></td>
                                <td><?= $task->created->format('d.m.Y h:i') ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>

                    <?= $this->element('pagination') ?>
                </div>
            </div>
        </div>
    </div>
</div>
</section>
