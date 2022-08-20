<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class UikitController extends AbstractController
{
    #[Route('/uikit', name: 'uikit')]
    public function uikit(): NotFoundHttpException|Response
    {
        if ($this->getParameter('kernel.environment') === 'prod') {
            throw new NotFoundHttpException();
        }

        $this->addFlash('info', 'info');
        $this->addFlash('success', 'succsess');
        $this->addFlash('warning', 'warning');
        $this->addFlash('danger', 'danger');

        return $this->render('pages/uikit.html.twig');
    }
}
