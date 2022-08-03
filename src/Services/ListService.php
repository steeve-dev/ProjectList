<?php

namespace App\Services;

use App\Entity\UserList;
use Symfony\Component\HttpFoundation\Response;

class ListService
{

    public function progression(UserList $list): int
    {
        $tasks = $list->getTasks();
        $taskComplete = 0;

        foreach ($tasks as $task) {
            if ($task->getStatus() == 'En cours') {
                $taskComplete += 1;
            } elseif ($task->getStatus() == 'Fini') {
                $taskComplete += 2;
            }
        }

        $percent = ($taskComplete/(2*$tasks->count()))*100;



        return $percent;

    }

}