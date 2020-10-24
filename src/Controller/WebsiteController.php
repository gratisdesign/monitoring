<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;

class WebsiteController extends AbstractController{

  /**
  * @Route("/")
  */
  public function home(){
    return $this->render('website/home.html.twig', []);
  }

}
