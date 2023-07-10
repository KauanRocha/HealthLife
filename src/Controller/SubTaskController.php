<?php

namespace App\Controller;

use App\Entity\SubTask;
use App\Repository\SubTaskRepository;
use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\sub;
use Doctrine\Persistence\ManagerRegistry;

use Symfony\Component\Routing\Annotation\Route;

class SubTaskController extends AbstractController
{
    #[Route('/subtasks', name: 'subTaskList', methods: ['GET'])]
    public function index(SubTaskRepository $subTaskRepository): JsonResponse
    {

        $subTask = $subTaskRepository->findAll();

        return $this->json([
            $subTask, 200, [], ['groups' => ['jsonSubTask']]
        ]);
    }

    #[Route('/subtasks/{subTask}', name: 'subTaskSingle', methods: ['GET'])]
    public function single(int $subTask, SubTaskRepository $subTaskRepository): JsonResponse
    {
        $subTask = $subTaskRepository->find($subTask);

        if (!$subTask) throw $this->createNotFoundException();

        #Estudar sobre symfony serializer
        return $this->json([
            $subTask, 200, [], ['groups' => ['jsonSubTask']]
        ]);
    }

    #[Route('/subtasks', name: 'subTaskCreate', methods: ['POST'])]
    public function create(Request $request, SubTaskRepository $subTaskRepository): JsonResponse
    {

        if ($request->headers->get('Content-Type') == 'application/json'){
            $data = $request->toArray();
        }else{
            $data = $request->request->all();
        }

        #Estudar sobre symfony serializer

        $subTask = new SubTask();

        $subTask->setTask();
        $subTask->setTitle($data['title']);
        $subTask->setCreatedAt(new \DateTimeImmutable ('now', new \DateTimeZone('America/Sao_Paulo')));
        $subTask->setUpdatedAt(new \DateTimeImmutable ('now', new \DateTimeZone('America/Sao_Paulo')));

        $subTaskRepository->save($subTask, true);


        return $this->json([
            'message' => 'Task created successfully!',
            'subTask' => $subTask
        ], 201);
    }

    #[Route('/tasks/{task}', name: 'taskUpdate', methods: ['PUT', 'PATCH'])]
    public function update(int $task, Request $request, ManagerRegistry $doctrine, TaskRepository $taskRepository): JsonResponse
    {
        $task = $taskRepository->find($task);

        if (!$task) throw $this->createNotFoundException();

        if ($request->headers->get('Content-Type') == 'application/json'){
            $data = $request->toArray();
        }else{
            $data = $request->request->all();
        }
        #Estudar sobre symfony serializer

        $task->setTitle($data['title']);
        $task->setUpdateAt(new \DateTimeImmutable ('now', new \DateTimeZone('America/Sao_Paulo')));


        $doctrine->getManager()->flush();

        return $this->json([
            'message' => 'SubTask updated successfully!',
            'data' => $task
        ], 201);
    }

    #[Route('/subtasks/{task}', name: 'subTaskDelete', methods: ['DELETE'])]
    public function delete(int $task, Request $request, TaskRepository $taskRepository): JsonResponse
    {

        $task = $taskRepository->find($task);

        $taskRepository->remove($task, true);

        return $this->json([
            'data' => $task
        ]);
    }

}
