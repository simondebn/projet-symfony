<?php
/**
 * Created by PhpStorm.
 * User: cdi
 * Date: 13/03/2018
 * Time: 09:46
 */

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route ;

class Home extends Controller
{
    /**
     * @Route ("/", name="home")
     */
    public function home()
    {
        return $this->render("base.html.twig");
    }
}