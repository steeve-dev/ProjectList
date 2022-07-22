<?php

namespace App\Controller;

use App\Entity\Task;
use App\Entity\User;
use App\Entity\UserList;
use App\Form\NewListType;
use App\Form\NewTaskType;
use App\Repository\UserListRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListDetailController extends AbstractController
{
    #[Route('/list/{id}', name: 'ListDetail')]
    public function ShowList(
        UserListRepository $userListRepository,
        Request $request,
        EntityManagerInterface $entityManager,
        int $id
    ): Response
    {
        //create a new list

        $newList = new UserList();
        $form = $this->createForm(NewListType::class, $newList);

        $form->handleRequest($request);

        // get the list of the current user

        $user = $this->getUser();
        $userList = $userListRepository->findBy(['user' => $user]);

        //Submit the form list

        if ($form->isSubmitted() && $form->isValid()) {

            $newList->setUser($this->getUser());
            $entityManager->persist($newList);
            $entityManager->flush();

            return $this->redirectToRoute('ListPage');

        }

        $task = new Task();
        $taskForm = $this->createForm(NewTaskType::class, $task);

        $taskForm->handleRequest($request);

        // get the tasks of the user list


        $taskDisplay = $userListRepository->findBy(['id'=>$id])[0];

        if ($taskForm->isSubmitted() && $taskForm->isValid()) {


            $task->setUserList($taskDisplay);
            $entityManager->persist($task);
            $entityManager->flush();

            return $this->redirectToRoute('ListDetail', [
                'id'=>$id,
            ]);

        }


        return $this->render('listPageDetail.html.twig', [
            'lists'=>$userList,
            'listForm'=>$form->createView(),
            'taskForm'=>$taskForm->createView(),
            'tasks'=>$taskDisplay
        ]);






    }

}