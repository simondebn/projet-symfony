<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class BlogController extends Controller
{
    /**
     * @Route("/blog", name="blog")
     * @Security ("has_role ('ADMIN')")
     */
    public function index()
    {
        return $this->render('blog/blog_main.html.twig', [
            'controller_name' => 'BlogController',
        ]);
    }
}
