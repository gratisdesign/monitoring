<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Uid\Ulid;

use App\Entity\Domain;

class DomainController extends AbstractController{

  /**
  * @Route("/monitoring/domain")
  */
  public function index(){
    $domains = $this->getUser()->getDomains();
    return $this->render('monitor/domain/index.html.twig', [
      'domains' => $domains
    ]);
  }

  /**
   * @Route("/monitoring/domain/create")
   */
  public function create(Request $request){
    $domain = new Domain();
    $domain->setUser($this->getUser());

    $form = $this->createFormBuilder($domain)
      ->add('name', TextType::class)
      ->add('address', TextType::class)
      ->add('save', SubmitType::class, ['label' => 'Add domain'])
      ->getForm();

    $form->handleRequest($request);
    if($form->isSubmitted() && $form->isValid()){
      $domain = $form->getData();
      $ulid = new Ulid();
      $domain->setUid($ulid);
      $em = $this->get('doctrine')->getManager();
      $em->persist($domain);
      $em->flush();
      return $this->redirectToRoute('app_domain_index');
    }

    return $this->render('monitor/domain/create.html.twig',[
      'form' => $form->createView(),
    ]);
  }

  /**
   * @Route("/monitoring/domain/{domain_uid}/view")
   */
  public function view(string $domain_uid){
    $em = $this->get('doctrine')->getManager();
    $domain = $em->getRepository(Domain::class)->findOneBy(['uid' => $domain_uid, 'user' => $this->getUser()->getId()]);

    return $this->render('monitor/domain/view.html.twig',[
      'domain' => $domain
    ]);
  }
  
  /**
   * @Route("/monitoring/domain/{domain_uid}/edit")
   */
  public function edit(Request $request, string $domain_uid){
    $em = $this->get('doctrine')->getManager();
    $domain = $em->getRepository(Domain::class)->findOneBy(['uid' => $domain_uid, 'user' => $this->getUser()]);

    $form = $this->createFormBuilder($domain)
      ->add('name', TextType::class)
      ->add('address', TextType::class)
      ->add('save', SubmitType::class, ['label' => 'Edit domain'])
      ->getForm();

    $form->handleRequest($request);
    if($form->isSubmitted() && $form->isValid()){
      $domain = $form->getData();
      $em->persist($domain);
      $em->flush();
      return $this->redirectToRoute('app_domain_index');
    }

    return $this->render('monitor/domain/edit.html.twig',[
      'domain' => $domain,
      'form' => $form->createView(),
    ]);
  }
    
}
