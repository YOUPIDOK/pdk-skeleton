<?php

namespace App\Controller\Main;

use Pdk\RgpdBundle\Repository\GCURepository;
use Pdk\RgpdBundle\Repository\PrivacyPolicyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

#[Route(name: 'rgpd__')]
class RGPDController extends AbstractController
{
    #[Route('/politique-de-confidentialite', name: 'privacy_policy', options: ['sitemap' => true])]
    public function privacyPolicy(PrivacyPolicyRepository $privacyPolicyRepository): Response
    {
        $currentPrivacyPolicy = $privacyPolicyRepository->findCurrentPrivacyPolicy();

        if ($currentPrivacyPolicy === null) throw new NotFoundHttpException();

        return $this->render('pages/rgpd/privacy_policy.html.twig', [
            'privacyPoliticy' => $currentPrivacyPolicy
        ]);
    }

    #[Route('/gcu', name: 'gcu', options: ['sitemap' => true])]
    public function cgu(GCURepository $CGURepository): Response
    {
        $currentCGU = $CGURepository->findCurrentCGU();

        if ($currentCGU === null) throw new NotFoundHttpException();

        return $this->render('pages/rgpd/cgu.html.twig', [
            'gcu' => $currentCGU
        ]);
    }
}