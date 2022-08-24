<?php

namespace App\Controller\Dev;

use App\Form\Dev\TestType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    #[Route('/test', name: 'test', condition: '%kernel.debug% === 1')]
    public function test(Request $request): Response
    {
        $form = $this->createForm(TestType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->addFlash('success', 'Success');

            return $this->redirectToRoute('test');
        }

        if ($form->isSubmitted() && !$form->isValid()) {
            $this->addFlash('danger', 'Error');
        }

        return $this->renderForm('pages/test.html.twig', [
            'form' => $form
        ]);
    }
}
