<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class HotwiredTurboExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('turbo', [$this, 'turbo']),
        ];
    }

    public function turbo(?bool $activate = null)
    {
        if ($activate === null) {
            $activate = isset($_ENV['APP_ENV']) && $_ENV['APP_ENV'] === 'prod';
        }

        return 'data-turbo=' . ($activate ? 'true' : 'false');
    }
}
