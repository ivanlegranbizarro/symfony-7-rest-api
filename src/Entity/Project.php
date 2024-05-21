<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: ProjectRepository::class)]
#[UniqueEntity('name', message: 'The name must be unique')]
class Project
{
  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column]
  #[Groups(['project:read'])]
  private ?int $id = null;

  #[ORM\Column(length: 255)]
  #[Assert\NotBlank]
  #[Assert\Length(min: 3, max: 100)]
  #[Groups(['project:read'])]
  private ?string $name = null;

  #[ORM\Column(type: Types::TEXT)]
  #[Assert\NotBlank]
  #[Assert\Length(min: 3, minMessage: 'The description must be at least 3 characters long')]
  #[Assert\Length(max: 1000, maxMessage: 'The description must be at most 1000 characters long')]
  #[Groups(['project:read'])]
  private ?string $description = null;

  public function getId(): ?int
  {
    return $this->id;
  }

  public function getName(): ?string
  {
    return $this->name;
  }

  public function setName(string $name): static
  {
    $this->name = $name;

    return $this;
  }

  public function getDescription(): ?string
  {
    return $this->description;
  }

  public function setDescription(string $description): static
  {
    $this->description = $description;

    return $this;
  }
}
