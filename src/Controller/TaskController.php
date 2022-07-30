<?php

namespace App\Controller;

use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TaskController extends AbstractController

{

    #[Route('/task/remove/{id}', name: 'taskRemove')]
    public function remove(int $id, TaskRepository $taskRepository, EntityManagerInterface $entityManager): Response
    {
        // find task to remove

        $task = $taskRepository->findBy(['id'=>$id])[0];
        $entityManager->remove($task);
        $entityManager->flush();


        // get the current list for the redirection

        $list = $task->getUserList();
        $listID =$list->getId();

        return $this->redirectToRoute('ListDetail', [
            'id'=>$listID,
        ]);
    }


}