<?php

namespace App\Subscriber\Sitemap;

use Presta\SitemapBundle\Event\SitemapPopulateEvent;
use Presta\SitemapBundle\Service\UrlContainerInterface;
use Presta\SitemapBundle\Sitemap\Url\GoogleMultilangUrlDecorator;
use Presta\SitemapBundle\Sitemap\Url\UrlConcrete;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;

class SitemapSubscriber implements EventSubscriberInterface
{
    // SITEMAP PARTS
    // TODO : COMPLETE

    // ROUTES
    // TODO : COMPLETE

    /**
     * @var UrlGeneratorInterface
     */
    private UrlGeneratorInterface $urlGenerator;
    private ParameterBagInterface $parameterBag;
    private RouterInterface $router;

    /**
     * @param UrlGeneratorInterface $urlGenerator
     * @param ParameterBagInterface $parameterBag
     * @param RouterInterface $router
     */
    public function __construct(
        UrlGeneratorInterface $urlGenerator,
        ParameterBagInterface $parameterBag,
        RouterInterface $router,
    ) {
        $this->urlGenerator      = $urlGenerator;
        $this->parameterBag      = $parameterBag;
        $this->router = $router;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            SitemapPopulateEvent::class => 'populate',
        ];
    }

    /**
     * @param SitemapPopulateEvent $event
     */
    public function populate(SitemapPopulateEvent $event): void
    {
        $this->registerStaticPages($event->getUrlContainer());
        $this->registerDynamicPages($event->getUrlContainer());
    }

    /**
     * @param UrlContainerInterface $urls
     */
    public function registerStaticPages(UrlContainerInterface $urls): void
    {
        // TODO : COMPLETE
    }

    private function registerDynamicPages(UrlContainerInterface $urls): void
    {
        // TODO : COMPLETE
//        $this->registerExemple($urls);
    }

//    private function registerExemple(UrlContainerInterface $urls): void
//    {
//        $context = $this->router->getContext();
//        $context->setScheme('https');
//
//        foreach ($this->exempleRepository->findAll() as $exemple) {
//            $this->router->setContext($context);
//
//            $uri = $this->router->generate(self::EXEMPLE_ROUTE, [
//                "slug" => $exemple->getSlug()
//            ], UrlGeneratorInterface::ABSOLUTE_URL);
//
//            $url = new UrlConcrete($uri);
//
//            $urls->addUrl($url, $this::EXEMPLES_PART);
//        }
//    }
}
