<?php

namespace App\Controller;

use App\Form\TestType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends CustomAbstractController
{
    #[Route('/test', name: 'test')]
    public function test(Request $request): Response
    {
        $form = $this->createForm(TestType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->addFlash('success', 'Success');
        }
        if ($form->isSubmitted() && !$form->isValid()) {
            $this->addFlash('danger', 'Error');
        }

        return $this->renderForm('pages/test.html.twig', [
            'form' => $form
        ]);
    }
}
