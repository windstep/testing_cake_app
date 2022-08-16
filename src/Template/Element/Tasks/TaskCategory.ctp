<?php
/**
 * @var string $priority
 * @var \App\Model\Entity\Task[] $tasks
 */
?>

<div class="priority <?= $priority ?>"><span><?= __($priority) ?></span></div>
<?php foreach ($tasks as $task): ?>
    <div class="task <?= $priority ?>">
        <div class="desc">
            <div class="title"><a href="<?= \Cake\Routing\Router::url(['_name' => 'tasks.view', 'id' => $task->id]) ?>"><?= h($task->title) ?></a></div>
            <div><?= h($task->description) ?></div>
        </div>
        <div class="time">
            <div class="date"><?= $task->created->format('d M Y') ?></div>
            <div><?= $task->created->timeAgoInWords(['format' => 'dd.MM.yyyy', 'end' => '+1 week']) ?></div>
        </div>
    </div>
<?php endforeach; ?>
