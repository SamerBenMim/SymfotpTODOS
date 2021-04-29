<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class TODOController extends AbstractController
{
    #[Route('/todo', name: 'todo')]
    public function index(SessionInterface $session ): Response
    {
        if(!$session->has("todo")){
            $todo=[ 'monday' => 'MATH' , 'tuesday'=>'FRENCH' ,'wednesday'=>'WEB'] ;
            $session->set('todo',$todo);
            $this->addFlash("messageVisit1","BIENVENU DANS VOTRE PLATFORM DE GESTION DE TODO");
        }
        return $this->render('todo/index.html.twig', []);
    }


    #[Route('/addtodo/{name}/{content}', name: 'addtodo')]

    public function addtodo($name ,$content,SessionInterface $session){
        if(!$session->has('todo')){
            $this->addFlash("messageVisit1","Pas de session");
        }else{
            $todo = $session->get('todo');
            if (isset($todo[$name])){
                $this->addFlash("messageerror","le todo $name existe déja");

            }else{
                $todo[$name]=$content;
                $session->set("todo",$todo);
                $this->addFlash("messagesucces","le todo $name a ete ajouter avec succes");

            }

        }
        return $this->redirectToRoute("todo");

    }
    #[Route('/deletetodo/{name}', name: 'deletetodo')]

    public function deletetodo($name,SessionInterface $session){
        if(!$session->has('todo')){
            $this->addFlash("messageVisit1","Pas de session");
        }else{
            $todo = $session->get('todo');
            if (!isset($todo[$name])){
                $this->addFlash("messageerror","le todo $name n'existe pas");

            }else{

                unset($todo[$name]);
                $session->set("todo",$todo);

                $this->addFlash("messagesucces","le todo $name a ete supprimer avec succes");

            }

        }
        return $this->redirectToRoute("todo");

    }


}
