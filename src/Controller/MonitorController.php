<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;

class MonitorController extends AbstractController{

  /**
  * @Route("/monitoring")
  */
  public function index(){
    return $this->render('monitor/index.html.twig', []);
  }

}
