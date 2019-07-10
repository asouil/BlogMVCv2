<?php
namespace App\Controller;
use \Core\Controller\Controller;
use App\Controller\PaginatedQueryAppController;
class MentionsController extends Controller
{
    public function mentions()
    {
        $title = "Mentions Légales";
        $this->render("mentions/mentions", [   "title" => $title  ]);
    }
    public function cgv()
    {
        $title = "Conditions générales de vente";
        $this->render("mentions/CGV", [   "title" => $title  ]);
    }
}
