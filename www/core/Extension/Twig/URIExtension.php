<?php

namespace Core\Extension\Twig;

use Twig\TwigFunction;
use Twig\Extension\AbstractExtension;
use Core\Controller\Controller;

class URIExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [new TwigFunction('uri', [$this, 'getURI'])];
    }
    public function getUri(string $cible="", ?array $params) :string
    {
        $test= new Controller();
        $uri = $_SERVER['REQUEST_SCHEME']."://".$_SERVER['HTTP_HOST'];
        $folder = $test->generateUrl($cible, $params);
        
        return $uri.$folder;
    }
}