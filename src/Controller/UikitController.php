<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class UikitController extends CustomAbstractController
{
    #[Route('/uikit', name: 'uikit')]
    public function uikit(): NotFoundHttpException|Response
    {
        $this->addFlash('info', 'info');
        $this->addFlash('success', 'succsess');
        $this->addFlash('warning', 'warning');
        $this->addFlash('danger', 'danger');

        return $this->render('pages/uikit.html.twig');
    }
}
