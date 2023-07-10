<?php

namespace App\Entity;

use App\Repository\SubTaskRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;

#[ORM\Entity(repositoryClass: SubTaskRepository::class)]
class SubTask
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["jsonTask", "jsonSubTask"])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["jsonTask", "jsonSubTask"])]
    private ?string $title = null;

    #[ORM\Column]
    #[Groups(["jsonTask", "jsonSubTask"])]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    #[Groups(["jsonTask", "jsonSubTask"])]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\Column(nullable: true)]
    #[Groups(["jsonTask", "jsonSubTask"])]
    private ?\DateTimeImmutable $finished = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(["jsonTask", "jsonSubTask"])]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'Subtasks')]
    #[MaxDepth(1)]
    private ?Task $task = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeImmutable $updated_at): static
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getFinished(): ?\DateTimeImmutable
    {
        return $this->finished;
    }

    public function setFinished(?\DateTimeImmutable $finished): static
    {
        $this->finished = $finished;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getTask(): ?Task
    {
        return $this->task;
    }

    public function setTask(?Task $task): static
    {
        $this->task = $task;

        return $this;
    }
}
