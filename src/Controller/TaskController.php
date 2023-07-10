<?php

namespace App\Controller;

use App\Repository\SubTaskRepository;
use App\Repository\TaskRepository;
use App\Service\TaskService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TaskController extends AbstractController
{
    #[Route('/tasks', name: 'taskList', methods: ['GET'])]
    public function index(TaskRepository $taskRepository): JsonResponse
    {
        $tasks = $taskRepository->findAll();
        return $this->json(
            $tasks, 200, [], ['groups' => ['jsonTask']]
        );
    }

    #[Route('/tasks/{task}', name: 'taskSingle', methods: ['GET'])]
    public function single(int $task, TaskRepository $taskRepository): JsonResponse
    {
        assert($task > 0, 'Task ID must be a positive integer.');
        $task = $taskRepository->find($task);

        if (!$task) {
            throw $this->createNotFoundException();
        }
        #Estudar sobre symfony serializer
        return $this->json(
            $task, 200, ['message' => 'Task created successfully!'], ['groups' => ['jsonTask']]
        );
    }

    #[Route('/tasks', name: 'taskCreate', methods: ['POST'])]
    public function create(Request $request, TaskService $taskService, TaskRepository $taskRepository, SubTaskRepository $subTaskRepository): JsonResponse
    {
        $data = $request->toArray();

        $task = $taskService->newTask($data, $taskRepository, $subTaskRepository);

        return $this->json(
            $task, 200, ['message' => 'Task created successfully!'], ['groups' => ['jsonTask']]
        );
    }

    #[Route('/tasks/{task}', name: 'taskUpdate', methods: ['PUT'])]
    public function update(int $task, TaskService $taskService, Request $request, TaskRepository $taskRepository, SubTaskRepository $subTaskRepository): JsonResponse
    {
        $task = $taskRepository->find($task);

        if(!$task) {
            throw $this->createNotFoundException();
        }

        $data = $request->toArray();

        $task = $taskService->alterTask($data, $task, $taskRepository, $subTaskRepository);

        return $this->json(
            $task, 200, ['message' => 'Task updated successfully!'], ['groups' => ['jsonTask']]
        );
    }

    #[Route('/tasks/{task}', name: 'taskDelete', methods: ['DELETE'])]
    public function delete(int $task, TaskService $taskService, TaskRepository $taskRepository): JsonResponse
    {

        $task = $taskRepository->find($task);

        if(!$task) {
            throw $this->createNotFoundException();
        }

        $taskService->deleteTask($task,$taskRepository);

        return $this->json(
            $task, 200, ['message' => 'Task deleted successfully!'], ['groups' => ['jsonTask']]
        );
    }
}
