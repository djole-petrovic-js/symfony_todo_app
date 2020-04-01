<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Todo;
use Symfony\Component\Validator\Validation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class AppController extends AbstractController {
  /**
   * @Route("/",name="list")
   */
  public function list() {
    $todos = $this->getDoctrine()->getRepository(Todo::class)->findAll();

    $todos = array_reduce($todos,function(array $acc,Todo $todo){
      $firstAndLastName = sprintf('%s %s',
        $todo->getFirstName(),
        $todo->getLastName()
      );

      if ( !isset($acc[$firstAndLastName]) ) {
        $acc[$firstAndLastName] = [];
      }

      $acc[$firstAndLastName][] = $todo;

      return $acc;
    },[]);
    
    return $this->render('list.html.twig',[
      'todos' => $todos
    ]);
  }
  /**
   * @Route("/admin/save/{id?}", name="save", requirements={"id": "\d+"})
   */
  public function save($id,Request $request) {
    $user = $this->getUser();
    /**
     * User object is always null, this is
     * uncommented for now.
     */
    // $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access this page!');

    $manager = $this->getDoctrine()->getManager();

    if ( !empty($id) ) {
      $todo = $manager->find(Todo::class,$id);

      if ( empty($todo) ) {
        $this->addFlash('error','Todo was not found');

        return $this->redirect('/');
      }
    } else {
      $todo = new Todo();
    }

    $form = $this->createForm(Todo::class,$todo);

    $form->handleRequest($request);

    if ( $form->isSubmitted() && $form->isValid() ) {
      try {
        $todo = $form->getData();

        $todo->setDateCreated(new \Datetime());
        
        $manager->persist($todo);
        $manager->flush();
  
        $this->addFlash('success','Todo has been successfully saved');
  
        return $this->redirect('/');
      } catch(Exception $e) {
        $this->addFlash('error',$e->getMessage());
      }
    }

    return $this->render('save.html.twig',[
      'form' => $form->createView()
    ]);
  }
  /**
   * @Route("/admin/destroy",name="destroy")
   */
  public function destroy(Request $request) {
    if ( $request->getMethod() !== 'POST' ) {
      $this->addFlash('error','Could not delete todo');

      return $this->redirect('/');
    }

    $manager = $this->getDoctrine()->getManager();

    $id = $request->get('id');

    if ( empty($id) ) {
      $this->addFlash('error','Could not find todo');

      return $this->redirect('/');
    }

    $todo = $manager->find(Todo::class,$id);

    if ( empty($todo) ) {
      $this->addFlash('error','Could not find todo');

      return $this->redirect('/');
    }

    $manager->remove($todo);
    $manager->flush();

    $this->addFlash('success','Todo has been successfully deleted');

    return $this->redirect('/');
  }
}