<?php

namespace App\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\Security\Core\Security;

class MenuBuilder
{
    private FactoryInterface $factory;
    private Security $security;

    public function __construct(FactoryInterface $factory, Security $security)
    {
        $this->factory = $factory;
        $this->security = $security;
    }

    public function createMainMenu(array $options): ItemInterface
    {
        $menu = $this->factory->createItem('main', [
            'attributes' => ['class' => 'navbar-nav']
        ]);

        if ($_ENV['APP_ENV'] === 'dev') {
            $menu
                ->addChild('Uikit', [
                    'route' => 'uikit',
                    'attributes' => ['class' => 'nav-item'],
                    'linkAttributes' => ['class' => 'nav-link']
                ])
                ->setExtra('icon', 'fa-solid fa-brush')
            ;

            $menu
                ->addChild('Test', [
                    'route' => 'test',
                    'attributes' => ['class' => 'nav-item'],
                    'linkAttributes' => ['class' => 'nav-link']
                ])
                ->setExtra('icon', 'fa-solid fa-gear')
            ;
        }

        if ($this->security->isGranted('ROLE_ADMIN')) {
            $menu
                ->addChild('Admin', [
                    'route' => 'sonata_admin_dashboard',
                    'attributes' => ['class' => 'nav-item'],
                    'linkAttributes' => ['class' => 'nav-link']
                ])
                ->setExtra('icon', 'fa-solid fa-lock')
            ;
        }

        return $menu;
    }

//    public function createSidebarMenu(array $options): ItemInterface
//    {
//        $menu = $this->factory->createItem('sidebar', [
//            'attributes' => ['class' => 'sidebar-menu']
//        ]);
//
//        $menu
//            ->addChild('Homepage', [
//                'route' => 'homepage',
//                'attributes' => ['class' => 'item']
//            ])
//            ->setExtra('icon', 'fa-solid fa-house')
//        ;
//
//        if ($_ENV['APP_ENV'] === 'dev') {
//            $menu
//                ->addChild('Uikit', [
//                    'route' => 'uikit',
//                    'attributes' => ['class' => 'item']
//                ])
//                ->setExtra('icon', 'fa-solid fa-brush')
//            ;
//
//            $menu
//                ->addChild('Test', [
//                    'route' => 'test',
//                    'attributes' => ['class' => 'item']
//                ])
//                ->setExtra('icon', 'fa-solid fa-gear')
//            ;
//        }
//
//        if ($this->security->isGranted('ROLE_ADMIN')) {
//            $menu
//                ->addChild('Admin', [
//                    'route' => 'sonata_admin_dashboard',
//                    'attributes' => ['class' => 'item']
//                ])
//                ->setExtra('icon', 'fa-solid fa-lock')
//            ;
//        }
//
//        return $menu;
//    }
}