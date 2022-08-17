<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Task Entity
 *
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property string|null $comment
 * @property string $status
 * @property int $author_id
 * @property int|null $executor_id
 * @property string $state
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $updated
 *
 * @property \App\Model\Entity\User $author
 * @property \App\Model\Entity\User $executor
 */
class Task extends Entity
{
    protected $_accessible = [
        'title' => true,
        'description' => true,
        'comment' => true,
        'status' => true,
        'author_id' => false,
        'executor_id' => true,
        'state' => true,
        'created' => false,
        'updated' => false,
    ];

    protected function _setExecutorId($executorId)
    {
        if ($executorId === 0) {
            $executorId = null;
        }

        return $executorId;
    }
}
