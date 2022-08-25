<?php

namespace App\Twig;

use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\Markup;
use Twig\TwigFilter;
use Twig\TwigFunction;

class BreadcrumbExtension extends AbstractExtension
{
    private Environment $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('breadcrumb_render', [$this, 'breadcrumbRender']),
        ];
    }

    public function breadcrumbRender(?array $data = []): Markup
    {
        /* $data struct */
        // [
        //      // Use an array if you want to override default page name
        //      [
        //          'route',
        //          'pageName'
        //      ],
        //      // Use a string if you want to use default page name
        //      'route'
        // ]

        $defaultPagesNames = [
            'homepage' => 'Homepage',
            'uikit' => 'Uikit',
            'test' => 'Test',
            // TODO : COMPLETE
        ];

        $breadcrumb = $this->twig->render('components/_breadcrumb.html.twig', [
            'data' => $data,
            'defaultPagesNames' => $defaultPagesNames
        ]);

        return new Markup( $breadcrumb, 'UTF-8' );
    }
}
