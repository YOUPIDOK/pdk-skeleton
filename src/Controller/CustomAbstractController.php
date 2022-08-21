<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Response;

class CustomAbstractController extends AbstractController
{
    protected function renderForm(string $view, array $parameters = [], Response $response = null): Response
    {
        if (null === $response) {
            $response = new Response();
        }

        $response->setStatusCode(200);

        foreach ($parameters as $k => $v) {
            if ($v instanceof FormView) {
                throw new \LogicException(sprintf('Passing a FormView to "%s::renderForm()" is not supported, pass directly the form instead for parameter "%s".', get_debug_type($this), $k));
            }

            if (!$v instanceof FormInterface) {
                continue;
            }

            $parameters[$k] = $v->createView();

            if ($v->isSubmitted() && !$v->isValid()) {
                $response->setStatusCode(422);
            }

            if ($v->isSubmitted() && $v->isValid()) {
                $response->setStatusCode(302);
            }
        }

        return $this->render($view, $parameters, $response);
    }
}