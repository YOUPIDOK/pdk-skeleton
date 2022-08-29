<?php

namespace App\Controller\Dev;

use App\Form\Dev\UiKitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class UikitController extends AbstractController
{
    #[Route('/uikit', name: 'uikit', condition: '%kernel.debug% === 1')]
    public function uikit(): NotFoundHttpException|Response
    {
        $this->addFlash('info', 'info');
        $this->addFlash('success', 'succsess');
        $this->addFlash('warning', 'warning');
        $this->addFlash('danger', 'danger');

        $form = $this->createForm(UiKitType::class);

        return $this->renderForm('dev/uikit.html.twig',[
            'form' => $form
        ]);
    }
}
