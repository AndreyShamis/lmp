<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PublicMainPageController extends AbstractController
{
    /**
     * @Route("/public/main/page", name="public_main_page")
     */
    public function index()
    {
        return $this->render('public_main_page/index.html.twig', [
            'controller_name' => 'PublicMainPageController',
        ]);
    }
}
