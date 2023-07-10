<?php

namespace App\Service;

use App\Entity\SubTask;
use App\Entity\Task;
use App\Repository\RecurringRepository;
use function Webmozart\Assert\Tests\StaticAnalysis\null;

class TaskService
{
    public function newTask($data, $taskRepository, $subTaskRepository, $recurringRepository): ?Task
    {

        #Estudar sobre symfony serializer
        $task = new Task();

        $recurring = $recurringRepository->find($data['recurring_id']);

        if(empty($data['description'])){
            $data['description'] = null;
        }

        $task->setTitle($data['title']);
        $task->setCreatedAt(new \DateTimeImmutable ('now', new \DateTimeZone('America/Sao_Paulo')));
        $task->setUpdatedAt(new \DateTimeImmutable ('now', new \DateTimeZone('America/Sao_Paulo')));
        $task->setRecurring($recurring);
        $task->setDescription($data['description']);

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
        $task->setRecurring($data['recurring']);
        $task->setDescription($data['description']);

        foreach ($data['Subtasks'] as $iValue) {

            if(empty($iValue['id'])) {
                $subTask = new SubTask();
                $subTask->setCreatedAt(new \DateTimeImmutable ('now', new \DateTimeZone('America/Sao_Paulo')));
            }else {
                $subTask = $subTaskRepository->find($iValue['id']);
            }

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