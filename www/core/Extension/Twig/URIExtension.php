<?php

namespace Core\Extension\Twig;

use Twig\TwigFunction;
use Twig\Extension\AbstractExtension;
use Core\Controller\URLController;

class URIExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [new TwigFunction('uri', [$this, 'getUri'])];
    }
    public function getUri(string $cible="", ?array $params=[]){
        return URLController::getUri($cible, $params);
    }
}