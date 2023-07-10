<?php

namespace App\Service;

use App\Entity\SubTask;
use App\Entity\Task;

class TaskService
{

    public function newTask2($data, $taskRepository, $subTaskRepository): ?Task
    {
        return 'teste';
    }
    public function newTask($data, $taskRepository, $subTaskRepository): ?Task
    {

        #Estudar sobre symfony serializer
        $task = new Task();

        $task->setTitle($data['title']);
        $task->setCreatedAt(new \DateTimeImmutable ('now', new \DateTimeZone('America/Sao_Paulo')));
        $task->setUpdatedAt(new \DateTimeImmutable ('now', new \DateTimeZone('America/Sao_Paulo')));

        foreach ($data['Subtasks'] as $iValue) {

            $subTask= new SubTask();
            $subTask->setTitle($iValue['title']);
            $subTask->setCreatedAt(new \DateTimeImmutable ('now', new \DateTimeZone('America/Sao_Paulo')));
            $subTask->setUpdatedAt(new \DateTimeImmutable ('now', new \DateTimeZone('America/Sao_Paulo')));


            $task->addSubtask($subTask);
            $subTaskRepository->save($subTask, false);

        }
        $taskRepository->save($task, true);

        return $task;
    }
    public function alterTask($data, $task, $taskRepository, $subTaskRepository): ?Task
    {

        $task->setTitle($data['title']);
        $task->setUpdatedAt(new \DateTimeImmutable ('now', new \DateTimeZone('America/Sao_Paulo')));

        foreach ($data['Subtasks'] as $iValue) {

            if(empty($iValue['id'])) {
                $subTask = new SubTask();
                $subTask->setCreatedAt(new \DateTimeImmutable ('now', new \DateTimeZone('America/Sao_Paulo')));
            }else $subTask = $subTaskRepository->find($iValue['id']);

            $subTask->setTitle($iValue['title']);
            $subTask->setUpdatedAt(new \DateTimeImmutable ('now', new \DateTimeZone('America/Sao_Paulo')));

            if(empty($iValue['id'])) {
                $task->addSubtask($subTask);
            }
            $subTaskRepository->save($subTask, false);
        }
        $taskRepository->save($task, true);

        return $task;
    }

    public function deleteTask($task, $taskRepository): ?Task
    {
        $subTasks = $task->getSubtasks()->toArray();

        foreach ($subTasks as $iValue) {

            $task->removeSubtask($iValue);
        }

        $taskRepository->remove($task, true);

        return $task;
    }
}