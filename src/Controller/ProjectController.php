<?php

namespace App\Controller;

use App\Entity\Project;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/api', name: 'api_')]
class ProjectController extends AbstractController
{
  #[Route('/projects', name: 'project_index', methods: ['GET'])]
  public function index(ProjectRepository $projectRepository): JsonResponse
  {
    $projects = $projectRepository->findAll();

    return $this->json($projects, 200, [], ['groups' => 'project:read']);
  }

  #[Route('/projects', name: 'project_create', methods: ['POST'])]
  public function create(Request $request, EntityManagerInterface $em, SerializerInterface $serializer, ValidatorInterface $validator): JsonResponse
  {
    // Deserializar la solicitud JSON en un objeto Project
    $project = $serializer->deserialize($request->getContent(), Project::class, 'json');

    // Validar la entidad Project
    $errors = $validator->validate($project);
    if (count($errors) > 0) {
      $errorsString = (string) $errors;
      return $this->json(['errors' => $errorsString], 400);
    }

    // Persistir la entidad en la base de datos
    $em->persist($project);
    $em->flush();

    // Retornar la respuesta JSON con el nuevo proyecto
    return $this->json($project, 201, [], ['groups' => 'project:read']);
  }

  #[Route('/projects/{id}', name: 'project_show', methods: ['GET'])]
  public function show(Project $project): JsonResponse
  {
    if (!$project) {
      return $this->json(['message' => 'Project not found'], 404);
    }
    return $this->json($project, 200, [], ['groups' => 'project:read']);
  }

  #[Route('/projects/{id}', name: 'project_update', methods: ['PUT'])]
  public function update(Request $request, Project $project, EntityManagerInterface $em, SerializerInterface $serializer, ValidatorInterface $validator): JsonResponse
  {

    if (!$project) {
      return $this->json(['message' => 'Project not found'], 404);
    }

    // Deserializar la solicitud JSON en un objeto Project
    $project = $serializer->deserialize($request->getContent(), Project::class, 'json');

    // Validar la entidad Project
    $errors = $validator->validate($project);
    if (count($errors) > 0) {
      $errorsString = (string) $errors;
      return $this->json(['errors' => $errorsString], 400);
    }

    // Persistir la entidad en la base de datos
    $em->persist($project);
    $em->flush();

    // Retornar la respuesta JSON con el nuevo proyecto
    return $this->json($project, 200, [], ['groups' => 'project:read']);
  }

  #[Route('/projects/{id}', name: 'project_delete', methods: ['DELETE'])]
  public function delete(Project $project, EntityManagerInterface $em): JsonResponse
  {
    if (!$project) {
      return $this->json(['message' => 'Project not found'], 404);
    }
    $em->remove($project);
    $em->flush();
    return $this->json(null, 204);
  }
}
