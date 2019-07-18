<?php
namespace Core\Controller;
use Core\Extension\Twig\URIExtension;
use Core\Extension\Twig\FlashExtension;
use Core\Extension\Twig\PriceExtension;
use Core\Controller\Session\FlashService;

class Controller
{
    private $twig;

    private $app;

    private $messageFlash;

    protected function render(string $view, array $variables = []): string
    {

        $variables["debugTime"] = $this->getApp()->getDebugTime();
        return $this->getTwig()->render(
            $view . '.twig',
            $variables
        );
    }

    private function getTwig()
    {
        if (is_null($this->twig)) {
            $loader = new \Twig\Loader\FilesystemLoader(dirname(dirname(__dir__)) . '/views/');
            $this->twig = new \Twig\Environment($loader);
            $this->twig->addGlobal('session', $_SESSION);
            $this->twig->addGlobal('constant', get_defined_constants());
            $this->twig->addExtension(new FlashExtension());
            $this->twig->addExtension(new PriceExtension());
            $this->twig->addExtension(new URIExtension());
        }
        return $this->twig;
    }

    protected function getApp()
    {
        if (is_null($this->app)) {
            $this->app = \App\App::getInstance();
        }
        return $this->app;
    }

    public function generateUrl(string $routeName, array $params = []): String
    {

        //génère une route URL dynamiquement pour accéder aux pages existentes. Si le chemin change, on n'a pas à toout modifier ensuite
        return $this->getApp()->getRouter()->url($routeName, $params);
    }

    protected function loadModel(string $nameTable): void
    {
        $this->$nameTable = $this->getApp()->getTable($nameTable);
    }

    protected function flash(): FlashService
    {
        return $this->getApp()->flash();
    }

    protected function messageFlash()
    {
        if(is_null($this->messageFlash)) {
            $this->messageFlash = new FlashController();
        }
        return $this->messageFlash;
    }
}
