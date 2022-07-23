<?php

namespace App\Entity;

use App\Repository\TaskRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TaskRepository::class)]
class Task
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private $name = null;

    #[ORM\Column(type: 'string', length: 255)]
    private $status = null;

    #[ORM\ManyToOne(targetEntity: UserList::class, inversedBy: 'tasks')]
    #[ORM\JoinColumn(nullable: false)]
    private $userList = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getUserList(): ?userList
    {
        return $this->userList;
    }

    public function setUserList(?userList $userList): self
    {
        $this->userList = $userList;

        return $this;
    }

}
