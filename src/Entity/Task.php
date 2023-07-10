<?php

namespace App\Entity;

use App\Repository\TaskRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;


#[ORM\Entity(repositoryClass: TaskRepository::class)]
class Task
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["jsonTask", "jsonSubTask"])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups("jsonTask")]
    private ?string $title = null;

    #[ORM\Column]
    #[Groups("jsonTask")]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    #[Groups("jsonTask")]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\Column(nullable: true)]
    #[Groups("jsonTask")]
    private ?\DateTimeImmutable $finished = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups("jsonTask")]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'task', targetEntity: SubTask::class)]
    #[Groups("jsonTask")]

    private Collection $Subtasks;

    public function __construct()
    {
        $this->Subtasks = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, SubTask>
     */
    public function getSubtasks(): Collection
    {
        return $this->Subtasks;
    }

    public function addSubtask(SubTask $subtask): static
    {
        if (!$this->Subtasks->contains($subtask)) {
            $this->Subtasks->add($subtask);
            $subtask->setTask($this);
        }

        return $this;
    }

    public function removeSubtask(SubTask $subtask): static
    {
        if ($this->Subtasks->removeElement($subtask)) {
            // set the owning side to null (unless already changed)
            if ($subtask->getTask() === $this) {
                $subtask->setTask(null);
            }
        }

        return $this;
    }
}
