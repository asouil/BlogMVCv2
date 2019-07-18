<?php

namespace Core\Extension\Twig;

use Twig\TwigFunction;
use Twig\Extension\AbstractExtension;

class PriceExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [new TwigFunction('getPttc', [$this, 'getPttc']),
                new TwigFunction('getPriceHT', [$this, 'getPriceHT'])];
    }

    public function getPttc($price): string
    {
        return number_format(($price * 1.2), 2, ',', '.').'€';
    }

    public function getPriceHT($price): string
    {
        return number_format($price, 2, ',', '.').'€';
    }
}