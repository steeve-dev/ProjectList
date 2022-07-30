<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController


{

#[Route('/', name: 'homePage')]
    public function home(UserRepository $userRepository): Response
{




    return $this->render('home.html.twig');
}


}