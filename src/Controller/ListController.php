<?php

namespace App\Controller;

use App\Entity\UserList;
use App\Form\NewListType;
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
        $list = new UserList();
        $form = $this->createForm(NewListType::class, $list);

        $form->handleRequest($request);
        $user = $this->getUser();
        $userList = $entityManager->getRepository(UserList::class)->findBy(['user'=>$user]);
        
        if ($form->isSubmitted() && $form->isValid()){

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


}