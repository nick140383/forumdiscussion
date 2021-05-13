<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class IndexController extends AbstractController
{
    /**

     * @Route("/", name="forpar")
     *
     */
    public function home()
    {
        // $content = "";
        return $this->render('home/index.html.twig');
    }


}