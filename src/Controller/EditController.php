<?php

namespace App\Controller;

use App\Form\NewListType;
use App\Form\NewTaskType;
use App\Repository\TaskRepository;
use App\Repository\UserListRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EditController extends AbstractController
{
    #[Route('/list/{id}/edit', name: 'listEdition')]
    public function ListEdit(UserListRepository $userListRepository, int $id, Request $request, EntityManagerInterface $entityManager, TaskRepository $taskRepository): Response
    {

        $list = $userListRepository->findBy(['id'=>$id])[0];
        $form = $this->createForm(NewListType::class, $list);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()){

            $entityManager->persist($list);
            $entityManager->flush();

        }




        return $this->render('editList.html.twig', [
            'list'=>$list,
            'form'=> $form->createView(),

        ]);
    }

    #[Route('/task/{id}/edit', name: 'taskEdit')]
    public function TaskEdit(TaskRepository $taskRepository, int $id, Request $request, EntityManagerInterface $entityManager): Response
    {

        $task = $taskRepository->findBy(['id'=>$id])[0];
        $list = $task->getUserList();
        $listid = $list->getId();

        $taskForm = $this->createForm(NewTaskType::class, $task);
        $taskForm->handleRequest($request);

        if ($taskForm->isSubmitted() && $taskForm->isValid()){

            $entityManager->persist($task);
            $entityManager->flush();

            return $this->redirectToRoute('ListDetail', [
                'id'=>$listid
            ]);

        }
        return $this->render('editTask.html.twig', [
            'taskForm'=>$taskForm->createView()
        ]);
    }
}