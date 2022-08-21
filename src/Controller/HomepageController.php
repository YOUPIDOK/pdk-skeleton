<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends CustomAbstractController
{
    #[Route('/', name: 'homepage', options: ['sitemap' => true])]
    public function index(): Response
    {
        return $this->render('pages/homepage.html.twig');
    }
}
