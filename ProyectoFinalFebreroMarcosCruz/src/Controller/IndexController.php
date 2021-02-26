<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/index", name="index")
     */
    public function index(): Response
    {
        $user = $this->getUser();
        if ($user!= null && $user->getRoles() == ["ROLE_ADMIN"]) {
            return $this->render('index/indexadmin.html.twig');
        }
        else
        {
            return $this->render('index/index.html.twig');
        }
    }

    /**
     * @Route("/antonio", name="antonio")
     */
    public function antonio(): Response
    {
        return $this->render('antonio/index.html.twig');
    }

}
