<?php

namespace App\Controller;

use App\Entity\UserList;
use App\Form\NewListType;
use App\Repository\UserListRepository;
use App\Services\ListService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListController extends AbstractController
{
    #[Route('/list', name: 'ListPage')]
    public function ListPage(Request $request, EntityManagerInterface $entityManager): Response
    {
        //create a new list

        $list = new UserList();
        $form = $this->createForm(NewListType::class, $list);

        $form->handleRequest($request);


        // get the list of the current user

        $user = $this->getUser();
        $userList = $entityManager->getRepository(UserList::class)->findBy(['user' => $user]);


        //Submit the form list

        if ($form->isSubmitted() && $form->isValid()) {

            $list->setUser($this->getUser());
            $entityManager->persist($list);
            $entityManager->flush();

            return $this->redirectToRoute('ListPage');

        }

        return $this->render('listPage.html.twig', [
            'lists'=>$userList,
            'listForm'=>$form->createView()
        ]);
    }

        #[Route('/list/remove/{id}', name: 'listRemove')]
        public function remove(UserListRepository $userListRepository, int $id, EntityManagerInterface $entityManager): Response
        {
            $list = $userListRepository->findBy(['id'=>$id])[0];
            $entityManager->remove($list);
            $entityManager->flush();


            return $this->redirectToRoute('ListPage');
        }


}