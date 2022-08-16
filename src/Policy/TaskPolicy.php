<?php

namespace App\Policy;

use App\Model\Entity\Task;
use Authorization\IdentityInterface;

class TaskPolicy
{
    public function canUpdate(IdentityInterface $user, Task $task)
    {
        return $user->id === $task->author_id ||
            $user->id === $task->executor_id;
    }

    public function canDelete(IdentityInterface $user, Task $task)
    {
        return $user->id === $task->author_id;
    }
}
